<?php

use common\widgets\grid\GridView;

$detailsLink = function($model) {
    return [
        'label' => __('Edit'),
        'href' => Url::to(['/partner/update', 'id' => $model->id]),
    ];
};

$columns = [
    ['class' => 'yii\grid\CheckboxColumn'],
    
    // ['attribute' => 'id', 'label' => '#'],

    ['class' => 'common\widgets\grid\ImageColumn'],
    
    [
        'attribute' => 'name',
        'link' => $detailsLink,
    ],
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
];


echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
]);
