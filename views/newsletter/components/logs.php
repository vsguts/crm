<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActionsDropdown;
use app\widgets\grid\GridExtraRowView;


$dropdown = ActionsDropdown::widget([
    'items' => [
        ['label' => __('Delete selected'), 'url' => Url::to(['log-delete', 'newsletter_id' => $model->id]), 'linkOptions' => [
            'data-c-process-items' => 'ids',
            'data-confirm' => __('Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ]],
    ],
]);
echo Html::tag('div', $dropdown, ['class' => 'pull-right buttons-container']);


echo GridExtraRowView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\CheckboxColumn'],
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

