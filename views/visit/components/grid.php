<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridView;

if (!empty($partnerId)) {
    $content = Html::a(__('Create visit'), ['/visit/update', 'partner_id' => $partnerId, '_return_url' => Url::to()], [
        'class' => 'btn btn-success c-modal',
        'data-target-id' => 'visit_create',
    ]);
    echo Html::tag('div', Html::tag('div', $content, ['class' => 'btn-group']), ['class' => 'pull-right']);
}

$columns = [
    ['class' => 'yii\grid\CheckboxColumn'],
    // ['attribute' => 'id', 'label' => '#'],
];

if (empty($partnerId)) {
    $columns[] = ['attribute' => 'partner.extendedName', 'label' => __('Partner')];
}

$columns[] = ['attribute' => 'user.name', 'label' => __('User')];
$columns[] = 'timestamp';
$columns[] = ['class' => 'app\widgets\grid\ActionColumn', 'size' => 'xs'];

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
    'controllerId' => 'visit',
    'detailsLinkPopup' => true,
    'ajaxPager' => !empty($partnerId),
]);

