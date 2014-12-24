<?php

namespace app\widgets;

use yii\widgets\InputWidget;
use yii\helpers\Html;

class ImagesUpdate extends InputWidget
{
    public $wrapperClass = 'col-sm-12';

    public $viewLink = '';
    
    public $objectId;

    public function init()
    {
        parent::init();
        $name = Html::getInputName($this->model, $this->attribute);

        echo '<div class="' . $this->wrapperClass . '">';
        $images = $this->model->getImages();
        foreach ($images as $image) {
            $this->image($image, $name);
        }
        
        echo '</div>';
        if ($this->viewLink) {
            echo Html::tag('div', '', ['class' => 'clearfix']);
            $options = [
                'class' => 'btn btn-default'
            ];
            if ($this->objectId) {
                Html::addCssClass($options, 'c-ajax');
                $options['data-result-ids'] = $this->objectId;
            }
            $link = Html::a(__('View images'), $this->viewLink, $options);
            echo Html::tag('div', $link, ['class' => 'pull-right']);
        }
    }

    protected function image($image, $name)
    {
        echo '<div class="images-upload-item">';
        echo '<div class="images-upload-item-content">';
        
        echo Html::a(Html::img($image->getUrl('180x180')), $image->getUrl(), ['target' => '_blank']);

        echo '<div class="checkbox">';
        echo Html::checkbox($name . '[delete][' . $image->id . ']', false, ['label' => 'Delete']);
        echo '</div>';
        
        if (!$image->default) {
            echo '<div class="radio">';
            echo Html::radio($name . '[default]', false, [
                'value' => $image->id,
                'label' => 'Set default'
            ]);
            echo '</div>';
        }
        
        echo '</div>';
        echo '</div>';
    }

}