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

    public $extraItems = [];

    protected function renderDataCellContent($model, $key, $index)
    {
        $detailsLinkOptions = $this->grid->prepareDetailsLink($model->id);
        $removeLinkOptions = $this->grid->prepareRemoveLink($model->id);

        $items = [
            [
                'label' => __('Edit'),
                'url' => $detailsLinkOptions['href'],
                'linkOptions' => $detailsLinkOptions
            ],
        ];

        foreach ($this->extraItems as $item) {
            $idField = !empty($item['idField']) ? $item['idField'] : 'id';
            $items[] = [
                'label' => $item['label'],
                'url' => $this->grid->prepareCustomLink($item['action'], [$idField => $model->id]),
                'linkOptions' => !empty($item['linkOptions']) ? $item['linkOptions'] : [],
            ];
        }

        $items[] = [
            'label' => __('Delete'),
            'url' => $removeLinkOptions['href'],
            'linkOptions' => $removeLinkOptions
        ];

        return ActionsDropdown::widget([
            'size' => $this->size,
            'items' => $items,
        ]);
    }

}
