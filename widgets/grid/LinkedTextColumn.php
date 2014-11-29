<?php

namespace app\widgets\grid;

use yii\grid\Column;
use yii\helpers\Html;
use yii\helpers\Url;

class LinkedTextColumn extends Column
{
    public $attribute;
    
    public $link_to = 'update';

    protected function renderHeaderCellContent()
    {
        $provider = $this->grid->dataProvider;
        $model = new $provider->query->modelClass;
        $label = $model->getAttributeLabel($this->attribute);

        return $label;
    }

    protected function renderDataCellContent($model, $key, $index)
    {
        $value = $model->{$this->attribute};
        $url = Url::to(['update', 'id' => $key]);
        
        return Html::a($value, $url, [
            // 'title' => Yii::t('yii', 'Update'),
            // 'data-pjax' => '0',
        ]);
    }
}