<?php

namespace app\widgets;

use yii\bootstrap\ButtonDropdown;

class ActionsDropdown extends ButtonDropdown
{
    public $label = '<span class="glyphicon glyphicon-cog"></span>';

    public $encodeLabel = false;

    public $options;

    public $dropdown = [
        'encodeLabels' => false,
        'options' => [
            'class' => 'dropdown-menu-right'
        ],
    ];

    public $layout = 'default';
    
    public $size = '';

    public $items = [];

    public function init()
    {
        parent::init();
        $this->dropdown['items'] = $this->items;
        $this->options['class'] = 'btn-' . $this->layout;
        if ($this->size) {
            $this->options['class'] .= ' btn-' . $this->size;
        }
    }
}