<?php

namespace app\widgets\form;

use app\helpers\Url;
use yii\helpers\Html;
use yii\widgets\InputWidget;

class TextLinks extends InputWidget
{
    public $value;

    public function init()
    {
        parent::init();
        
        $value = $this->value;

        if (is_null($value) && $this->attribute) {
            $value = $this->model->{$this->attribute};
        }

        if ($links = Url::parseUrlFromText($value)) {
            echo Html::beginTag('ul');
            foreach ($links as $link) {
                echo Html::tag('li', Html::a($link, $link, ['target' => '_blank']));
            }
            echo Html::endTag('ul');
        }

    }
}
