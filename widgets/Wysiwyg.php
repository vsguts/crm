<?php

namespace app\widgets;

use yii\imperavi\Widget;

class Wysiwyg extends Widget
{
    // Some options, see http://imperavi.com/redactor/docs/
    public $options = [
        'buttonSource' => true,
    ];

    public $plugins = [
        'fullscreen',
        'clips',
        'table',
    ];

}
