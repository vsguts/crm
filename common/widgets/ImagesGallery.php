<?php

namespace common\widgets;

use yii\helpers\Html;
use yii\widgets\InputWidget;

class ImagesGallery extends InputWidget
{
    public $wrapperClass = 'col-sm-12';

    public $editLink = '';

    public $objectId;

    public $lastGallery;

    public function init()
    {
        parent::init();

        echo '<div class="' . $this->wrapperClass . '">';
        $items = [];
        
        $images = $this->model->getImages();
        foreach ($images as $image) {
            $items[] = [
                'url' => $image->getUrl(),
                'src' => $image->getUrl('180x180'),
            ];
        }
        
        echo Gallery::widget([
            'options' => [
                'id' => $this->objectId . '_gallery',
            ],
            'items' => $items
        ]);

        if ($this->editLink) {
            echo Html::tag('div', '', ['class' => 'clearfix']);
            $options = [
                'class' => 'btn btn-default'
            ];
            if ($this->objectId) {
                Html::addCssClass($options, 'app-ajax');
                $options['data-target-id'] = $this->objectId;
            }
            $link = Html::a(__('Edit images'), $this->editLink, $options);
            echo Html::tag('div', $link, ['class' => 'pull-right']);
        }
        
        echo '</div>';
    }

    public static function renderTemplate()
    {
        $gallery = \Yii::createObject(['class' => Gallery::className()]);
        echo $gallery->renderTemplate();
    }

}