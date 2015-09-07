<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridView;
use app\widgets\ActionsDropdown;

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="pull-right buttons-container">
        <div class="btn-group">
            <?= Html::a(Yii::t('app', 'Create user'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <?= ActionsDropdown::widget([
            'layout' => 'info',
            'items' => [
                ['label' => __('Delete'), 'url' => Url::to(['delete']), 'linkOptions' => [
                    'data-c-process-items' => 'ids',
                    'data-confirm' => __('Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                ]],
                // ['label' => 'TODO 2', 'url' => '#'],
                // '<li role="presentation" class="divider"></li>',
            ],
        ]) ?>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('components/search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            ['attribute' => 'id', 'label' => '#'],
            'username',
            'email:email',
            'fullname',
            [
                'attribute' => 'role',
                'value' => function($model, $key, $index, $column){
                    return $model->getLookupItem('role', $model->role);
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model, $key, $index, $column){
                    return $model->getLookupItem('status', $model->status);
                }
            ],
            // 'country_id',
            // 'state_id',
            // 'state',
            // 'city',
            // 'address',
            // 'created_at',
            // 'updated_at',

            ['class' => 'app\widgets\grid\ActionColumn', 'size' => 'xs'],
        ],
    ]); ?>

</div>
