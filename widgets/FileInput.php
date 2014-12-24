<?php

namespace app\widgets;

use kartik\widgets\FileInput as KFileInput;

class FileInput extends KFileInput
{
    public $options = [
        'accept' => 'image/*',
        'multiple' => true,
    ];

    public $pluginOptions = [
        'showCaption' => false,
        'showUpload' => false,
    ];
}