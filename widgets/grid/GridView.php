<?php

namespace app\widgets\grid;

use yii\grid\GridView as YGridView;

class GridView extends YGridView
{
    
    public $dataColumnClass = 'app\widgets\grid\DataColumn';

    public $layout = "{pager}\n{items}\n{pager}";
    
    public $tableOptions = ['class' => 'table table-striped'];

    public $pager = [
        'class' => 'app\widgets\Pager',
    ];

}