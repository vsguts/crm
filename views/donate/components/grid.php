<?php

use yii\helpers\Html;
use app\widgets\grid\GridView;

if (!empty($partnerId)) {
    echo '<div class="pull-right">';
    echo '<div class="btn-group">';
    echo Html::a(Yii::t('app', 'Create donate'), ['/donate/create', 'partner_id' => $partnerId], ['class' => 'btn btn-success']);
    echo '</div>';
    echo '</div>';
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
$columns[] = ['class' => 'app\widgets\grid\ActionColumn', 'size' => 'xs'];

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
]);

