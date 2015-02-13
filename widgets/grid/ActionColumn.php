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
    
    public $size;

    protected function renderDataCellContent($model, $key, $index)
    {
        $detailsLinkOptions = $this->grid->prepareDetailsLink($model->id);
        $removeLinkOptions = $this->grid->prepareRemoveLink($model->id);

        return ActionsDropdown::widget([
            'size' => $this->size,
            'items' => [
                [
                    'label' => __('Edit'),
                    'url' => $detailsLinkOptions['href'],
                    'linkOptions' => $detailsLinkOptions
                ],
                [
                    'label' => __('Delete'),
                    'url' => $removeLinkOptions['href'],
                    'linkOptions' => $removeLinkOptions
                ],
            ],
        ]);
    }
}
