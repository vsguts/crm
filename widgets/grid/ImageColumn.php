<?php

namespace app\widgets\grid;

use app\models\ImagePlaceholder;
use yii\helpers\Html;

class ImageColumn extends DataColumn
{
    public $showHeader = false;

    public $showImagePlaceholder = false;

    protected function renderHeaderCellContent()
    {
        if ($this->showHeader) {
            return __('Image');
        }
    }

    protected function renderDataCellContent($model, $key, $index)
    {
        $image = $model->getImage();

        if ($image instanceof ImagePlaceholder && !$this->showImagePlaceholder) {
            return null;
        }

        $imageUrl = $model->getImage()->getUrl('50x50');
        $image = Html::img($imageUrl);

        if ($options = $this->getLinkOptions($model)) {
            return Html::a($image, null, $options);
        }

        return $image;

    }

}