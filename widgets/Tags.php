<?php

namespace app\widgets;

use app\models\Tag;
use kartik\widgets\Select2;

class Tags extends Select2
{
    public function init()
    {
        $this->options = [
            'placeholder' => __('Select a tags ...'),
        ];
        $attribute = $this->attribute;
        $this->attribute = $attribute . 'Str';
        
        $models = Tag::find()->$attribute()->all();
        $tags = [];
        foreach ($models as $model) {
            $tags[] = $model->name;
        }
        
        $this->pluginOptions = [
            'tags' => $tags,
            'tokenSeparators' => [',', ';'],
            'maximumInputLength' => 64,
            'allowClear' => true,
        ];

        parent::init();
    }
}
