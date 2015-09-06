<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridExtraRowView;

echo GridExtraRowView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'timestamp:datetime',
        [
            'attribute' => 'user.name',
            'label' => __('User')
        ],
        ['class' => 'app\widgets\grid\ToggleColumn'],
    ],
    'extraRow' => [
        'format' => 'raw',
        'value' => function($model, $key, $index, $column){
            return Html::tag('div', nl2br($model->content), ['class' => 'well']);
        },
    ],
    'extraRowColspan' => '4',
]);

