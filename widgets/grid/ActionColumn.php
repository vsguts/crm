<?php

namespace app\widgets\grid;

use Yii;
use yii\grid\Column;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActionsDropdown;

class ActionColumn extends Column
{
    public $attribute;
    
    public $link_to = 'update';
    
    public $size;

    protected function renderDataCellContent($model, $key, $index)
    {
        return ActionsDropdown::widget([
            'size' => $this->size,
            'items' => [
                ['label' => Yii::t('yii', 'Update'), 'url' => Url::to(['update', 'id' => $key])],
                ['label' => __('Delete'), 'url' => Url::to(['delete', 'id' => $key]), 'linkOptions' => [
                    'data-confirm' => __('Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                ]],
            ],
        ]);
    }
}
