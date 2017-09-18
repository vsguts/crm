<?php

namespace common\widgets\grid;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class GridExtraRowView extends GridView
{
    public $enableLinks = false;
    public $tableOptions = ['class' => 'table'];
    public $extraRow;
    public $extraRowColspan = 10;
    
    public function init()
    {
        parent::init();
        $this->initExtraRow();
    }

    public function renderTableRow($model, $key, $index)
    {
        $row = parent::renderTableRow($model, $key, $index);

        $cell = $this->extraRow->renderDataCell($model, $key, $index);
        $options['data-key'] = is_array($key) ? json_encode($key) : (string) $key;
        $options['data-key'] .= '-extra';
        $options['class'] = 'h';
        $row .= PHP_EOL . Html::tag('tr', $cell, $options);

        return $row;
    }

    private function initExtraRow()
    {
        if (is_string($this->extraRow)) {
            $this->extraRow = $this->createDataColumn($this->extraRow);
        } else {
            $this->extraRow = Yii::createObject(array_merge([
                'class' => $this->dataColumnClass ? : 'yii\grid\DataColumn',
                'grid' => $this,
            ], $this->extraRow));
        }
        $this->extraRow->contentOptions = ['colspan' => $this->extraRowColspan];
    }

}
