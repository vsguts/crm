<?php

namespace app\widgets\grid;

use app\widgets\ActionsDropdown;
use Closure;
use yii\grid\Column;

class ActionColumn extends Column
{
    public $attribute;

    public $size;

    public $items = [];

    protected function renderDataCellContent($model, $key, $index)
    {
        $action_items = [];

        foreach ($this->items as $item) {
            if ($item instanceof Closure) {
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
            } elseif (is_string($item)) {
                $action_items[] = $item;
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
