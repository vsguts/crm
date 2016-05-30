<?php

namespace app\widgets;

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

        $this->separator = sprintf('← %s →', __('between'));

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

        $this->pluginOptions['format'] = strtolower(Yii::$app->formatter->dateFormat);

        parent::init();
    }
}