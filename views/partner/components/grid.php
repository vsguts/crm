<?php

use app\models\Partner;
use app\widgets\grid\GridView;

$detailsLink = function($model) {
    return [
        'label' => __('Edit'),
        'href' => Url::to(['/partner/update', 'id' => $model->id]),
    ];
};

$columns = [
    ['class' => 'yii\grid\CheckboxColumn'],
    
    // ['attribute' => 'id', 'label' => '#'],

    ['class' => 'app\widgets\grid\ImageColumn'],
    
    [
        'attribute' => 'name',
        'link' => $detailsLink,
    ],
    'email:email',
    'city',
    [
        'attribute' => 'type',
        'value' => function(Partner $model, $key, $index, $column){
            return $model->getLookupItem('type', $model->type);
        }
    ],
    [
        'attribute' => 'status',
        'value' => function(Partner $model, $key, $index, $column){
            return $model->getLookupItem('status', $model->status);
        }
    ],
    'created_at:date',

    [
        'class' => 'app\widgets\grid\ActionColumn',
        'size' => 'xs',
        'items' => [
            $detailsLink,
            function(Partner $model) {
                if ($model->canManage()) {
                    return [
                        'label' => __('Delete'),
                        'href' => Url::to(['partner/delete', 'id' => $model->id, '_return_url' => Url::to()]),
                        'data-method' => 'post',
                        'data-confirm' => __('Are you sure you want to delete this item?'),
                    ];
                }
            },
        ],
    ],
];


echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
]);
