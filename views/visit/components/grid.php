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
$columns[] = 'created_at';
$columns[] = 'updated_at';
$columns[] = ['class' => 'app\widgets\grid\ActionColumn'];

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'dataColumnClass' => 'app\widgets\grid\DataColumn',
    'tableOptions' => ['class' => 'table'],
    'columns' => $columns,
]);

?>