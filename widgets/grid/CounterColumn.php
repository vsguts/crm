<?php

namespace app\widgets\grid;

use yii\base\Exception;
use yii\helpers\Html;

class CounterColumn extends DataColumn
{
    public $count;

    public $showEmpty = true;

    protected function renderDataCellContent($model, $key, $index)
    {
        if (!$this->count) {
            throw new Exception("Count is empty");
        }

        if (is_callable($this->count)) {
            $count = call_user_func($this->count, $model, $key, $index, $this);
        } else {
            $count = $this->count;
        }

        if (empty($count) && !$this->showEmpty) {
            return '';
        }

        $content = Html::tag('span', $count, ['class' => 'badge']);

        return $this->dataCellContentWrapper($content, $model);
    }
}
