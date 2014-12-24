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

        if ($url = $this->getUrl($model)) {
            return Html::a($text, $url);
        }

        return $text;
    }

    protected function getUrl($model)
    {
        $link = '';
        if (!empty($this->grid->view->params['override_controller_name'])) {
            $link = $this->grid->view->params['override_controller_name'] . '/';
        }
        
        if ($this->link_to && in_array($this->format, ['text'])) {
            $link .= $this->link_to;
            return Url::to([$link, 'id' => $model->id]);
        }
    }

}