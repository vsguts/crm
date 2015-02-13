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

        echo Html::beginTag('div', ['class' => $this->wrapperClass]);
        foreach ($this->model->getImages() as $image) {
            $this->image($image, $name);
        }
        
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

        echo Html::endTag('div');
    }

    protected function image($image, $name)
    {
        echo Html::beginTag('div', ['class' => 'images-upload-item']);
        echo Html::beginTag('div', ['class' => 'images-upload-item-content']);
        
        echo Html::a(Html::img($image->getUrl('180x180')), $image->getUrl(), ['target' => '_blank']);

        $checkbox = Html::checkbox($name . '[delete][' . $image->id . ']', false, ['label' => __('Delete')]);
        echo Html::tag('div', $checkbox, ['class' => 'checkbox']);
        
        if (!$image->default) {
            $radio = Html::radio($name . '[default]', false, [
                'value' => $image->id,
                'label' => __('Set default')
            ]);
            echo Html::tag('div', $radio, ['class' => 'radio']);
        }
        
        echo Html::endTag('div');
        echo Html::endTag('div');
    }

}