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

    public $items = [];

    protected function renderDataCellContent($model, $key, $index)
    {
        $action_items = [];

        foreach ($this->items as $item) {
            if ($options = $item($model)) {
                $label = $options['label'];
                unset($options['label']);
                $url = $options['href'];
                unset($options['href']);
                $action_items[] = [
                    'label' => $label,
                    'url' => $url,
                    'linkOptions' => $options,
                ];
            }
        }

        if ($action_items) {
            return ActionsDropdown::widget([
                'size' => $this->size,
                'items' => $action_items,
            ]);
        }
    }

}
