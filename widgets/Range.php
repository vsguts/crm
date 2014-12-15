<?php

namespace app\widgets;

use yii\helpers\Html;
use yii\widgets\InputWidget;

class Range extends InputWidget
{
    public $attribute2;

    public $separator;

    public $options2 = [];

    public function init()
    {
        if (empty($this->attribute2)) {
            $this->attribute2 = $this->attribute . '_to';
        }

        if (empty($this->separator)) {
            $this->separator = sprintf('← %s →', __('between'));
        }

        if (empty($this->options)) {
            $this->options = [
                'placeholder' => __('From'),
            ];
        }

        if (empty($this->options2)) {
            $this->options2 = [
                'placeholder' => __('To'),
            ];
        }

        parent::init();

        Html::addCssClass($this->options, 'form-control');
        Html::addCssClass($this->options2, 'form-control');
        
        $input1 = Html::activeTextInput($this->model, $this->attribute, $this->options);
        $input2 = Html::activeTextInput($this->model, $this->attribute2, $this->options2);
        $separator = Html::tag('span', $this->separator, ['class' => 'input-group-addon']);
        
        echo Html::tag('div', $input1 . $separator . $input2, ['class' => 'input-group']);
    }
}