<?php

use app\widgets\grid\GridView;

$columns = [
    ['class' => 'yii\grid\CheckboxColumn'],
    
    ['attribute' => 'id', 'label' => '#'],

    ['class' => 'app\widgets\grid\ImageColumn'],
    
    'name',
    'email:email',
    'city',
    ['attribute' => 'typeName', 'label' => Yii::t('app', 'Type')],
    ['attribute' => 'statusName', 'label' => Yii::t('app', 'Status')],
    'created_at:date',
    // 'country_id',
    // 'state_id',
    // 'state',
    // 'address',
    // 'church_id',
    // 'volunteer',
    // 'candidate',
    // 'notes:ntext',
    // 'updated_at',

    // ['class' => 'app\widgets\grid\ActionColumn'],
];


echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
    'controllerId' => 'partner',
]);
