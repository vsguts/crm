<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridView;

if (!empty($partnerId)) {
    $content = Html::a(__('Create donate'), ['/donate/update', 'partner_id' => $partnerId, '_return_url' => Url::to()], [
        'class' => 'btn btn-success c-modal',
        'data-target-id' => 'donate_create',
    ]);
    echo Html::tag('div', Html::tag('div', $content, ['class' => 'btn-group']), ['class' => 'pull-right']);
}

$columns = [
    ['class' => 'yii\grid\CheckboxColumn'],
    'id',
];

if (empty($partnerId)) {
    $columns[] = ['attribute' => 'partner.name', 'label' => __('Partner')];
}

$columns[] = 'sum';
$columns[] = 'timestamp';
$columns[] = 'created_at:date';
$columns[] = 'updated_at:date';
$columns[] = ['class' => 'app\widgets\grid\ActionColumn', 'size' => 'xs'];

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
    'controllerId' => 'donate',
    'detailsLinkPopup' => true,
]);

