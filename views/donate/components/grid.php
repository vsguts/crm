<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridView;

$detailsLink = function($model) {
    return [
        'label' => __('Edit'),
        'class' => 'app-modal',
        'href' => Url::to(['/donate/update', 'id' => $model->id, '_return_url' => Url::to()]),
        'data-target-id' => 'donate_' . $model->id,
    ];
};

if (!empty($partnerId)) {
    $content = Html::a(__('Create donate'), ['/donate/update', 'partner_id' => $partnerId, '_return_url' => Url::to()], [
        'class' => 'btn btn-success btn-sm app-modal',
        'data-target-id' => 'donate_create',
    ]);
    echo Html::tag('div', Html::tag('div', $content, ['class' => 'btn-group']), ['class' => 'pull-right']);
}

$columns = [
    [
        'class' => 'yii\grid\CheckboxColumn'
    ],
    'partner' => [
        'attribute' => 'partner.extendedName',
        'label' => __('Partner'),
        'link' => $detailsLink,
    ],
    'sum' => [
        'attribute' => 'sum',
        'value' => function($model, $key, $index, $column) {
            return Yii::$app->formatter->asDecimal($model->sum) . ' руб.';
        },
    ],
    'timestamp',

    [
        'class' => 'app\widgets\grid\ActionColumn',
        'size' => 'xs',
        'items' => [
            $detailsLink,
            function($model) {
                if (Yii::$app->user->can('donate_manage')) {
                    return [
                        'label' => __('Delete'),
                        'href' => Url::to(['donate/delete', 'id' => $model->id, '_return_url' => Url::to()]),
                        'data-method' => 'post',
                        'data-confirm' => __('Are you sure you want to delete this item?'),
                    ];
                }
            },
        ],
    ],
];

if (!empty($partnerId)) {
    $columns['sum']['link'] = $columns['partner']['link']; // Move to sum
    unset($columns['partner']);
}

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
    'ajaxPager' => !empty($partnerId),
]);

