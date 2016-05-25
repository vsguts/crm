<?php

namespace app\widgets\grid;

use yii\helpers\Html;
use yii\helpers\Url;

class ToggleColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index)
    {
        $icon = Html::tag('span', '', ['class' => 'glyphicon glyphicon-menu-down', 'aria-hidden' => 'true']);
        return Html::a($icon, '', ['class' => 'app-grid-toggle']);
    }
}
