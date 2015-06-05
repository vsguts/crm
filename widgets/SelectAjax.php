<?php

namespace app\widgets;

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\InputWidget;

class SelectAjax extends InputWidget
{
    public $multiple = false;

    public $initValueText;
    
    public $initObject;

    public $organizations = false;

    public function init()
    {
        if (!$this->options) {
            $this->options = [
                'class' => 'form-control m-select2',
                'placeholder' => __('Partners search'),
                'data-m-url' => Url::to(['partner/list']),
            ];
        }

        if ($this->organizations) {
            $this->options['data-m-organizations-only'] = 1;
        }

        if ($this->initValueText) {
            $this->options['data-init-value-text'] = $this->initValueText;
        }

        parent::init();
    }

    public function run()
    {
        if ($this->multiple) {
            
            // Existing items
            if ($this->initObject) {
                $items = [$this->initObject];
            } else {
                $attribute = rtrim($this->attribute, '[]');
                if ($pos = strpos($attribute, '_ids')) {
                    $attribute = substr($attribute, 0, $pos);
                }
                $items = $this->model->$attribute;
            }
            $extra_class = '';
            if ($items) {
                $extra_class = 'm-item-hidden';
                foreach ($items as $item) {
                    $content = [
                        Html::tag('div', $item->name, ['class' => 'col-sm-11 form-text-value']),
                        Html::activeHiddenInput($this->model, $this->attribute, ['value' => $item->id]),
                        $this->multipleButtons(),
                    ];
                    echo Html::tag('div', implode(' ', $content), ['class' => 'row m-item m-item-text']);
                }
            }

            echo Html::beginTag('div', ['class' => 'row m-item ' . $extra_class]);
            echo Html::beginTag('div', ['class' => 'col-sm-11']);
        }

        if ($this->hasModel()) {
            echo Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textInput($this->name, $this->value, $this->options);
        }

        if ($this->multiple) {
            echo Html::endTag('div');
            echo $this->multipleButtons();
            echo Html::endTag('div');
        }
    }

    protected function multipleButtons()
    {
        $buttons = [
            Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']), ['class' => 'm-item-new']),
            Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash']), ['class' => 'm-item-remove']),
        ];

        $content = implode(' ' , $buttons);
        
        return Html::tag('div', $content, ['class' => 'col-sm-1 form-text-value']);
    }

}
