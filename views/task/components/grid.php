<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridView;

if (!empty($partnerId)) {
    $content = Html::a(__('Create task'), ['/task/update', 'partner_id' => $partnerId, '_return_url' => Url::to()], [
        'class' => 'btn btn-success c-modal',
        'data-target-id' => 'task_create',
    ]);
    echo Html::tag('div', Html::tag('div', $content, ['class' => 'btn-group']), ['class' => 'pull-right']);
}

$columns = [
    ['class' => 'yii\grid\CheckboxColumn'],
    ['attribute' => 'id', 'label' => '#'],
    'name',
];

$columns[] = [
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
];
$columns[] = ['attribute' => 'user.name', 'label' => __('User')];
$columns[] = ['attribute' => 'done', 'class' => 'app\widgets\grid\CheckboxColumn'];
$columns[] = 'timestamp';
$columns[] = ['class' => 'app\widgets\grid\ActionColumn', 'size' => 'xs'];

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
    'controllerId' => 'task',
    'detailsLinkPopup' => true,
    'ajaxPager' => !empty($partnerId),
]);

