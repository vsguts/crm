<?php

namespace app\models\export;

use Yii;
use yii\base\Model;

abstract class AExport extends Model
{
    public $position = 10;
    
    public $fields;
    public $delimiter;
    public $filename;
    public $ids;
    
    public function rules()
    {
        return [
            [['fields', 'delimiter', 'filename'], 'required'],
            [['ids'], 'safe'],
        ];
    }

    abstract public function find();

    public function init()
    {
        parent::init();
        $this->fields = array_keys($this->getAvailableFields());
        $this->filename = strtolower($this->getClassName()) . '_' . date('Y-m-d') . '.csv';
    }

    public function getName()
    {
        return __($this->getClassName());
    }

    public function getId()
    {
        return strtolower($this->getClassName());
    }

    abstract public function getAvailableFields();

    public function export()
    {
        $query = $this->find();
        if ($this->ids) {
            if (is_string($this->ids)) {
                $this->ids = explode(',', $this->ids);
            }
            $models = $query->where(['id' => $this->ids])->all();
        } else {
            $models = $query->all(); // FIXME
        }
        
        header('Content-type: text/csv');
        header('Content-disposition: attachment;filename=' . $this->filename);

        $this->exportHeaders();

        $field_rules = $this->getFieldsRules();
        foreach ($models as $model) {
            $this->exportRow($model, $field_rules);
        }

        exit;
    }

    public function exportHeaders()
    {
        $available = $this->getAvailableFields();

        $headers = [];
        foreach ($this->fields as $field) {
            $headers[] = $available[$field];
        }
        
        echo implode($this->delimiter, $headers) . "\r\n";
    }

    public function exportRow($model, $rules = [])
    {
        $row = [];
        foreach ($this->fields as $field) {
            $data = $this->getModelValue($model, $field);
            if (!empty($rules[$field])) {
                $rule = $rules[$field];
                if (!empty($rule['replaceBy'])) {
                    $data = $this->getModelValue($model, $rule['replaceBy']);
                }
                if (!empty($rule['handler'])) {
                    $data = call_user_func_array($rule['handler'], [$data, $model, $field]);
                }
                if (!empty($rule['escape'])) {
                    if (!empty($data)) {
                        $data = '"' . str_replace('"', '\"', $data) . '"';
                    }
                }
                if (!empty($rule['format'])) {
                    $data = Yii::$app->formatter->{$rule['format']}($data);
                }
            }
            
            $row[] = $data;
        }

        echo implode($this->delimiter, $row) . "\r\n";
    }

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

    public function attributeLabels()
    {
        return [
            'fields' => Yii::t('app', 'Fields'),
            'delimiter' => Yii::t('app', 'Delimiter'),
            'filename' => Yii::t('app', 'Filename'),
            'ids' => Yii::t('app', 'Selected items'),
        ];
    }

    public function getAvailableDelimiters()
    {
        return [
            ';' => __('Semicolon'),
            ',' => __('Comma'),
        ];
    }

    public function getFieldsRules()
    {
    }

    protected function getClassName()
    {
        $name = get_class($this);
        return substr($name, strrpos($name, '\\') + 1);
    }

    protected function getModelFields($model)
    {
        $fields = [];
        foreach ($model->attributes() as $attribute) {
            $fields[$attribute] = $model->getAttributeLabel($attribute);
        }

        return $fields;
    }

    protected function convertLookupItem($data, $model, $field)
    {
        return $model->getLookupItem($field, $data);
    }



}
