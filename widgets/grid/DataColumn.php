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

        if (in_array($this->format, ['text', 'date', 'datetime'])) {
            return Html::a($text, null, $this->grid->prepareDetailsLink($model->id));
        }

        return $text;
    }

}