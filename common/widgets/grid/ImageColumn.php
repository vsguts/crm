<?php

namespace common\widgets\grid;

use yii\helpers\Html;

class ImageColumn extends DataColumn
{
    public $show_header = false;

    protected function renderHeaderCellContent()
    {
        if ($this->show_header) {
            return __('Image');
        }
    }

    protected function renderDataCellContent($model, $key, $index)
    {
        $image_url = $model->getImage()->getUrl('50x50');
        $image = Html::img($image_url);

        if ($options = $this->getLinkOptions($model)) {
            return Html::a($image, null, $options);
        }

        return $image;

    }

}