<?php

namespace app\widgets;

use yii\helpers\Html;
use yii\widgets\InputWidget;
use dosamigos\gallery\Gallery;

class ImagesGallery extends InputWidget
{
    public $wrapperClass = 'col-sm-12';

    public $editLink = '';

    public $objectId;

    public function init()
    {
        parent::init();
        $name = Html::getInputName($this->model, $this->attribute);

        echo '<div class="' . $this->wrapperClass . '">';
        $items = [];
        
        $images = $this->model->getImages();
        foreach ($images as $image) {
            $items[] = [
                'url' => $image->getUrl(),
                'src' => $image->getUrl('180x180'),
            ];
        }
        
        echo Gallery::widget(['items' => $items]);

        if ($this->editLink) {
            echo Html::tag('div', '', ['class' => 'clearfix']);
            $options = [
                'class' => 'btn btn-default'
            ];
            if ($this->objectId) {
                Html::addCssClass($options, 'c-ajax');
                $options['data-result-ids'] = $this->objectId;
            }
            $link = Html::a(__('Edit images'), $this->editLink, $options);
            echo Html::tag('div', $link, ['class' => 'pull-right']);
        }
        
        echo '</div>';
    }

}