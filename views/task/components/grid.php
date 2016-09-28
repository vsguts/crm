<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridView;

$detailsLink = function($model) {
    return [
        'label' => __('Edit'),
        'class' => 'app-modal',
        'href' => Url::to(['/task/update', 'id' => $model->id, '_return_url' => Url::to()]),
        'data-target-id' => 'task_' . $model->id,
    ];
};

if (!empty($partnerId)) {
    $content = Html::a(__('Create task'), ['/task/update', 'partner_id' => $partnerId, '_return_url' => Url::to()], [
        'class' => 'btn btn-success btn-sm app-modal',
        'data-target-id' => 'task_create',
    ]);
    echo Html::tag('div', Html::tag('div', $content, ['class' => 'btn-group']), ['class' => 'pull-right']);
}

$columns = [
    ['class' => 'yii\grid\CheckboxColumn'],
    [
        'attribute' => 'name',
        'link' => $detailsLink,
    ],
    [
        'label' => __('Partner'),
        'format' => 'raw',
        'value' => function($model, $key, $index, $column) {
            $count = count($model->partners);
            if ($count == 1) {
                return $model->partners[0]->extendedName;
            } else {
                return '<span class="badge">' . $count . '</span>';
            }
        }
    ],
    [
        'attribute' => 'user.name',
        'label' => __('User')
    ],
    [
        'attribute' => 'done',
        'class' => 'app\widgets\grid\CheckboxColumn'
    ],
    'timestamp',
    [
        'class' => 'app\widgets\grid\ActionColumn',
        'size' => 'xs',
        'items' => [
            $detailsLink,
            function($model) {
                if (Yii::$app->user->can('task_manage')) {
                    return [
                        'label' => __('Delete'),
                        'href' => Url::to(['task/delete', 'id' => $model->id, '_return_url' => Url::to()]),
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
    'ajaxPager' => !empty($partnerId),
]);

