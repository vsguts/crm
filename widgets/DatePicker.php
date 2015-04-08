<?php

namespace app\widgets;

use Yii;
use kartik\date\DatePicker as KDatePicker;

class DatePicker extends KDatePicker
{
    public $form_id;

    public function init()
    {
        $this->options['id'] = $this->form_id . '_timestamp';
        $this->options['placeholder'] = __('Select date');
        $this->pluginOptions['autoclose'] = true;
        $this->pluginOptions['format'] = strtolower(Yii::$app->formatter->dateFormat);

        parent::init();
    }
}