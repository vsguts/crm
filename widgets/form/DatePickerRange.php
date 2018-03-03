<?php

namespace app\widgets\form;

use Yii;
use kartik\date\DatePicker;

class DatePickerRange extends DatePicker
{
    public $type = DatePicker::TYPE_RANGE;

    public $pluginOptions = ['autoclose' => true];

    public function init()
    {
        if (empty($this->attribute2)) {
            $this->attribute2 = $this->attribute . '_to';
        }

        if (empty($this->options)) {
            $this->options = [
                'placeholder' => __('Start date'),
            ];
        }

        if (empty($this->options2)) {
            $this->options2 = [
                'placeholder' => __('End date'),
            ];
        }

        $value = $this->model->{$this->attribute};
        if (is_numeric($value)) {
            $this->options['value'] = Yii::$app->formatter->asDate($value);
        }

        $value = $this->model->{$this->attribute2};
        if (is_numeric($value)) {
            $this->options2['value'] = Yii::$app->formatter->asDate($value);
        }

        $this->separator = sprintf('← %s →', __('between'));

        $this->pluginOptions['format'] = strtolower(Yii::$app->formatter->dateFormat);

        parent::init();
    }
}