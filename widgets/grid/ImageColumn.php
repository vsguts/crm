<?php

namespace app\widgets\grid;

use yii\helpers\Url;
use yii\helpers\Html;

class ImageColumn extends DataColumn
{
    protected function renderHeaderCellContent()
    {
        return __('Image');
    }

    protected function renderDataCellContent($model, $key, $index)
    {
        $image_url = $model->getImage()->getUrl('50x50');
        $image = Html::img($image_url);
        return Html::a($image, $this->getUrl($model));
    }

}