<?php

use yii\grid\GridView;

$columns = [
    ['class' => 'yii\grid\CheckboxColumn'],
    'id',
];

if (empty($hidePartner)) {
    $columns[] = ['attribute' => 'partner.name', 'label' => __('Partner')];
}

$columns[] = ['attribute' => 'user.name', 'label' => __('User')];
$columns[] = 'timestamp';
$columns[] = ['class' => 'app\widgets\grid\ActionColumn', 'size' => 'xs'];

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'dataColumnClass' => 'app\widgets\grid\DataColumn',
    'tableOptions' => ['class' => 'table'],
    'columns' => $columns,
]);

?>