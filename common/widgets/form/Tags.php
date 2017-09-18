<?php

namespace common\widgets\form;

use common\models\Tag;
use kartik\widgets\Select2;

class Tags extends Select2
{
    public $placeholder;
    public $placeholder_from_label = false;

    public function init()
    {
        if ($this->placeholder_from_label) {
            $placeholder = $this->model->getAttributeLabel($this->attribute);
        } else {
            $placeholder = $this->placeholder ?: __('Select a tags...');
        }

        $this->options = [
            'placeholder' => $placeholder,
        ];

        $attribute = $this->attribute;
        $this->attribute = $attribute . 'Str'; // FIXME
        
        $models = Tag::find()->permission()->$attribute()->all();
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
