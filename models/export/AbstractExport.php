<?php

namespace app\models\export;

use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
use app\helpers\Tools;

abstract class AbstractExport extends Model
{
    const BATCH_LIMIT = 500;

    /**
     * Formatter name: csv or xls
     * @var [type]
     */
    public $formatter;

    /**
     * CSV delimiter
     * @var string
     */
    public $delimiter;

    /**
     * Export file name
     * @var string
     */
    public $filename;

    /**
     * Object IDs
     * @var array
     */
    public $ids = [];

    /**
     * Object query params (instead IDs)
     * @var array
     */
    public $queryParams = [];

    /**
     * Hide columns array
     * @var array
     */
    public $hide_columns = [];

    public function rules()
    {
        return [
            [['formatter', 'delimiter', 'filename'], 'required'],
        ];
    }

    public function init()
    {
        parent::init();

        // Prepare Filename
        $this->filename = Inflector::underscore(Tools::className($this)) . '_' . date('Y-m-d');
    }

    /**
     * Get Active Query
     * @return ActiveQuery
     */
    public function find()
    {
        return null;
    }

    /**
     * Gets result data
     * @return ActiveQuery
     */
    public function findData()
    {
        return null;
    }

    public function export($file_path = null)
    {
        if ($query = $this->find()) {
            $data = $this->processQuery($query);
        } else {
            $models = $this->findData();
            $data = $this->prepareData($models);
        }

        $formatter = Yii::createObject([
            'class'   => 'app\models\export\formatter\\' . ucfirst($this->formatter),
            'owner'   => $this,
            'columns' => array_keys($this->columns),
            'data'    => $data,
        ]);

        $formatter->export($file_path);

        if (!$file_path) {
            exit;
        }
    }

    public function attributeLabels()
    {
        return [
            'filename' => __('Filename'),
            'formatter' => __('Format'),
            // CSV
            'delimiter' => __('Delimiter'),
        ];
    }

    public function getAvailableDelimiters()
    {
        return [
            ';' => __('Semicolon'),
            ',' => __('Comma'),
        ];
    }

    public function getColumns()
    {
        $columns = $this->getColumnsDirect();

        // Prepare columns
        if ($this->hide_columns) {
            foreach ($columns as $name => $field) {
                if (in_array($field, $this->hide_columns)) {
                    unset($columns[$name]);
                }
            }
        }

        return $columns;
    }

    abstract protected function getColumnsDirect();

    protected function processQuery($query)
    {
        $data = [];
        foreach ($query->batch(self::BATCH_LIMIT) as $models) {
            $_data = $this->prepareData($models);
            foreach ($_data as $row) {
                $data[] = $row;
            }
        }
        return $data;
    }

    protected function prepareData($models)
    {
        $data = [];

        foreach ($models as $model) {
            $row = [];
            foreach ($this->columns as $column => $field) {
                @list($field, $format) = explode('|', $field, 2);
                $value = '';
                if (strpos($field, 'Callback:') === 0) { // Callback
                    list(, $method) = explode(':', $field, 2);
                    $value = call_user_func([$this, $method], $model);
                } elseif (strpos($field, 'Lookup:') === 0) { // Lookup
                    list(, $field) = explode(':', $field, 2);
                    $variants = $this->getLookupItems($model, $field);
                    $value = $variants[$model->$field];
                } elseif (strpos($field, 'Bool:') === 0) { // Boolean
                    list(, $field) = explode(':', $field, 2);
                    $value = $model->$field ? 'Yes' : 'No';
                } elseif (strpos($field, '.') && strpos($field, ':')) { // relation
                    list($field, $relation_data) = explode(':', $field, 2);
                    list($entity, $entity_field) = explode('.', $relation_data, 2);
                    $variants = $this->getList($model, $entity, $entity_field);
                    $value = $variants[$this->getModelValue($model, $field)];
                } else { // just field
                    $value = $this->getModelValue($model, $field);
                }
                
                // Formatter
                if ($format) {
                    $method = 'as' . ucfirst($format);
                    $value = Yii::$app->formatter->$method($value);
                }
                
                $row[$column] = $value;
            }
            $data[] = $row;
        }

        return $data;
    }

    protected function getModelValue($model, $field)
    {
        $parts = explode('.', $field);
        $result = $model;
        foreach ($parts as $part) {
            if (is_object($result) && isset($result->$part)) {
                $result = $result->$part;
            } elseif (is_array($result) && isset($result[$part])) {
                $result = $result[$part];
            } else {
                $result = '';
                break;
            }
        }

        return $result;
    }

    protected function getList($model, $entity, $entity_field)
    {
        static $cache = [];

        if (!isset($cache[$entity])) {
            $class = 'app\\models\\' . $entity;
            $cache[$entity] = $class::find()->scroll();
        }

        return $cache[$entity];
    }

    protected function getLookupItems($model, $field)
    {
        static $cache = [];

        if (!isset($cache[$field])) {
            $cache[$field] = $model->getLookupItems($field);
        }

        return $cache[$field];
    }

}
