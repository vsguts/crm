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
        $link = '';
        if (!empty($this->grid->view->params['override_controller_name'])) {
            $link = $this->grid->view->params['override_controller_name'] . '/';
        }
        
        $text = parent::renderDataCellContent($model, $key, $index);

        if ($this->link_to && in_array($this->format, ['text'])) {
            $link .= $this->link_to;
            $url = Url::to([$link, 'id' => $key]);
            return Html::a($text, $url);
        } else {
            return $text;
        }
    }

}