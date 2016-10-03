<?php

namespace app\widgets;

use Yii;

class DatePicker extends \kartik\date\DatePicker
{
    // public $form_id;

    public function init()
    {
        // $id = $this->form_id ?: uniqid();
        // $this->options['id'] = $id . '_timestamp';
        
        if ($this->model) {
            $value = $this->model->{$this->attribute};
            if (is_numeric($value)) {
                $this->options['value'] = Yii::$app->formatter->asDate($value);
            }
        }

        if (!empty($this->value) && is_numeric($this->value)) {
            $this->value = Yii::$app->formatter->asDate($this->value);
        }
        
        if (empty($this->options['placeholder'])) {
            $this->options['placeholder'] = __('Select date');
        }

        $this->pluginOptions['autoclose'] = true;
        $this->pluginOptions['format'] = strtolower(Yii::$app->formatter->dateFormat);

        parent::init();
    }
}