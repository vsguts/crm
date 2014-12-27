<?php

namespace app\widgets\grid;

use yii\grid\GridView as YGridView;

class GridView extends YGridView
{
    
    // public $layout = "{summary}\n{items}\n{pager}";
    public $layout = "{pager}\n{items}\n{pager}";
    
    public $pager = [
        'class' => 'app\widgets\Pager',
    ];

}