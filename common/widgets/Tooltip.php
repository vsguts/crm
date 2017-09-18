<?php

namespace common\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class Tooltip extends Widget
{
    public $tooltip;

    public function run()
    {
        echo Html::tag('span', '', ['data-toggle' => 'tooltip', 'title' => $this->tooltip, 'class' => 'glyphicon glyphicon-question-sign']);
    }
}
