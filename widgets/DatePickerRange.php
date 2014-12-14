<?php

namespace app\widgets;

use kartik\date\DatePicker;

class DatePickerRange extends DatePicker
{
    public $type = DatePicker::TYPE_RANGE;

    public $pluginOptions = ['autoclose' => true];

    public function init()
    {
        $this->attribute2 = $this->attribute . '_to';

        $this->separator = __('between');

        $this->options = [
            'placeholder' => __('Start date'),
        ];

        $this->options2 = [
            'placeholder' => __('End date'),
        ];
        parent::init();
    }
}