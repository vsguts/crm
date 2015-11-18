<?php

namespace app\models\export;

use Yii;
use yii\base\Model;

abstract class AExport extends Model
{
    // sidebox positions
    public $position = 10;

    // Export fields map
    public $attributesMap = [];
    
    // form fields
    public $formatter;
    public $fields;
    public $delimiter;
    public $filename;
    public $ids;
    
    public function rules()
    {
        return [
            [['formatter', 'fields', 'delimiter', 'filename'], 'required'],
            [['ids'], 'safe'],
        ];
    }

    public function init()
    {
        parent::init();
        $this->fields = array_keys($this->getAvailableFields());
        $this->filename = strtolower(getClassName($this)) . '_' . date('Y-m-d');
    }

    public function getName()
    {
        return __(getClassName($this));
    }

    public function getId()
    {
        return strtolower(getClassName($this));
    }

    abstract public function getModelClassName();

    public function getAvailableFields()
    {
        $class = $this->getModelClassName();
        $model = new $class;

        $fields = [];
        $post_fields = [];
        foreach ($model->attributes() as $attribute) {
            $key = !empty($this->attributesMap[$attribute]) ? $this->attributesMap[$attribute] : $attribute;
            $value = $model->getAttributeLabel($attribute);
            if (in_array($key, ['created_at', 'updated_at'])) {
                $post_fields[$key] = $value;
            } else {
                $fields[$key] = $value;
            }
        }

        $fields = array_merge($fields, $post_fields);

        return $fields;
    }

    public function export()
    {
        $class = $this->getModelClassName();
        $query = $class::find();
        if ($this->ids) {
            if (is_string($this->ids)) {
                $this->ids = explode(',', $this->ids);
            }
            $models = $query->where(['id' => $this->ids])->all();
        } else {
            $models = $query->all(); // FIXME
        }

        $formatter = Yii::createObject([
            'class'   => 'app\models\export\formatter\\' . ucfirst($this->formatter),
            'owner'   => $this,
            'columns' => $this->prepareColumns(),
            'data'    => $this->prepareData($models),
        ]);

        $formatter->export();

        exit;
    }

    public function attributeLabels()
    {
        return [
            'filename' => __('Filename'),
            'ids' => __('Selected items'),
            'formatter' => __('Format'),
            // CSV
            'fields' => __('Fields'),
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

    protected function getFieldsRules()
    {
        return [
            'created_at' => ['format' => 'asDate'],
            'updated_at' => ['format' => 'asDate'],
        ];
    }

    protected function prepareColumns()
    {
        $available = $this->getAvailableFields();

        $columns = [];
        foreach ($this->fields as $field) {
            $columns[$field] = $available[$field];
        }

        return $columns;
    }

    protected function prepareData($models)
    {
        $data = [];

        $field_rules = $this->getFieldsRules();
        foreach ($models as $model) {
            $row = [];
            foreach ($this->fields as $field) {
                $value = $this->getModelValue($model, $field);
                if (!empty($field_rules[$field])) {
                    $rule = $field_rules[$field];
                    if (!empty($rule['bool'])) {
                        $value = $value ? __('Yes') : __('No');
                    }
                    if (!empty($rule['handler'])) {
                        $value = call_user_func_array($rule['handler'], [$value, $model, $field]);
                    }
                    if (!empty($rule['format'])) {
                        $value = Yii::$app->formatter->{$rule['format']}($value);
                    }
                }
                $row[$field] = $value;
            }
            $data[] = $row;
        }

        return $data;
    }

    /**
     * Geting model value, e.g. 'partner.name'
     * @param  Model  $model [description]
     * @param  string $field Extended field name
     * @return mixed
     */
    protected function getModelValue($model, $field)
    {
        if (strpos($field, '.')) {
            $data = $model;
            foreach (explode('.', $field) as $field_part) {
                if (isset($data->$field_part)) {
                    $data = $data->$field_part;
                } else {
                    return '';
                }
            }
            return $data;
        }

        return $model->$field;
    }

    // Handlers

    protected function convertLookupItem($data, $model, $field)
    {
        return $model->getLookupItem($field, $data);
    }

}
