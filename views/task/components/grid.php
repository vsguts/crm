<?php

use yii\helpers\Html;
use yii\grid\GridView;

if (!empty($partnerId)) {
    echo '<div class="pull-right">';
    echo '<div class="btn-group">';
    echo Html::a(Yii::t('app', 'Create visit'), ['/visit/create', 'partner_id' => $partnerId], ['class' => 'btn btn-success']);
    echo '</div>';
    echo '</div>';
}

$columns = [
    ['class' => 'yii\grid\CheckboxColumn'],
    'id',
    'name',
];

if (empty($partnerId)) {
    $columns[] = ['attribute' => 'partner.name', 'label' => __('Partner')];
}

$columns[] = ['attribute' => 'user.name', 'label' => __('User')];
$columns[] = ['attribute' => 'done', 'class' => 'app\widgets\grid\CheckboxColumn'];
$columns[] = 'timestamp';
$columns[] = ['class' => 'app\widgets\grid\ActionColumn', 'size' => 'xs'];

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'dataColumnClass' => 'app\widgets\grid\DataColumn',
    'tableOptions' => ['class' => 'table'],
    'columns' => $columns,
]);

