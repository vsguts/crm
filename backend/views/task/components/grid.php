<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\grid\GridView;

/** @var \yii\data\ActiveDataProvider $dataProvider */

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
        'attribute' => 'id',
        'link' => $detailsLink,
    ],
    [
        'attribute' => 'timestamp',
        'format' => 'date',
        'link' => $detailsLink,
    ],
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
        },
        'link' => function($model) {
            if (Yii::$app->user->can('partner_view')) {
                $count = count($model->partners);
                if ($count == 1) {
                    return Url::to(['partner/update', 'id' => $model->partners[0]->id]);
                } else {
                    $ids = [];
                    foreach ($model->partners as $partner) {
                        $ids[] = $partner->id;
                    }
                    return Url::to(['partner/index', 'id' => $ids]);
                }
            }
        },
    ],
    [
        'attribute' => 'user',
        'value' => 'user.name',
        'link' => function($model) {
            if ($model->user_id && Yii::$app->user->can('user_view')) {
                return [
                    'href' => Url::to(['user/update', 'id' => $model->user_id, '_return_url' => Url::to()]),
                    'class' => 'app-modal',
                    'data-target-id' => 'user_' . $model->user_id,
                ];
            }
        },
    ],
    [
        'attribute' => 'done',
        'class' => 'common\widgets\grid\CheckboxColumn'
    ],
    [
        'class' => 'common\widgets\grid\ActionColumn',
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

