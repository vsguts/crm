<?php

use app\widgets\grid\GridView;

$columns = [
    ['class' => 'yii\grid\CheckboxColumn'],
    
    ['attribute' => 'id', 'label' => '#'],

    ['class' => 'app\widgets\grid\ImageColumn'],
    
    'name',
    'email:email',
    'city',
    [
        'attribute' => 'type',
        'value' => function($model, $key, $index, $column){
            return $model->getLookupItem('type', $model->type);
        }
    ],
    [
        'attribute' => 'status',
        'value' => function($model, $key, $index, $column){
            return $model->getLookupItem('status', $model->status);
        }
    ],
    'created_at:date',
    // 'country_id',
    // 'state_id',
    // 'state',
    // 'address',
    // 'parent_id',
    // 'volunteer',
    // 'candidate',
    // 'notes:ntext',
    // 'updated_at',

    // ['class' => 'app\widgets\grid\ActionColumn'],
];


echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
    'controllerId' => 'partner',
]);
