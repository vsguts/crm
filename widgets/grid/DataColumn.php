<?php

namespace app\widgets\grid;

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\DataColumn as YDataColumn;

class DataColumn extends YDataColumn
{
    public $link_to = 'update';

    protected function renderDataCellContent($model, $key, $index)
    {
        $text = parent::renderDataCellContent($model, $key, $index);

        if ($this->link_to && in_array($this->format, ['text'])) {
            $url = Url::to([$this->link_to, 'id' => $key]);
            return Html::a($text, $url);
        } else {
            return $text;
        }
    }

}