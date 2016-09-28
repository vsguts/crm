<?php

namespace app\widgets\grid;

use yii\helpers\Html;
use yii\grid\DataColumn as YDataColumn;

class DataColumn extends YDataColumn
{
    /**
     * Link options
     * @var Closure
     */
    public $link = false;

    protected function renderDataCellContent($model, $key, $index)
    {
        $text = parent::renderDataCellContent($model, $key, $index);

        if ($options = $this->getLinkOptions($model)) {
            $url = null;
            if (is_string($options)) {
                $url = $options;
                $options = [];
            }
            return Html::a($text, $url, $options);
        }

        return $text;
    }

    protected function getLinkOptions($model)
    {
        if (
            $this->link
            && is_callable($this->link)
        ) {
            return call_user_func($this->link, $model);
        }
    }

}
