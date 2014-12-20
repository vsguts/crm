<?php

namespace app\widgets\grid;

use yii\helpers\Html;
use yii\helpers\Url;

class CheckboxColumn extends DataColumn
{
    public $disabled = true;

    protected function renderDataCellContent($model, $key, $index)
    {
        $value = $model->{$this->attribute};
        
        return Html::checkbox('', $value, ['disabled' => $this->disabled]);
    }
}