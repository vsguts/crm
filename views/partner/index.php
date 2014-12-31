<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActionsDropdown;
use app\widgets\grid\GridView;

$this->title = Yii::t('app', 'Partners');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="partner-index">

    <div class="pull-right">
        <div class="btn-group">
            <?= Html::a(Yii::t('app', 'Create partner'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <?= ActionsDropdown::widget([
            'layout' => 'info',
            'items' => [
                ['label' => __('Delete selected'), 'url' => Url::to(['delete']), 'linkOptions' => [
                    'data-c-process-items' => 'ids',
                    'data-confirm' => __('Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                ]],
                '<li role="presentation" class="divider"></li>',
                ['label' => __('Show on map'), 'url' => Url::to(['map']), 'linkOptions' => [
                    'data-c-process-items' => 'ids',
                ]],
            ],
        ]) ?>
    </div>
    
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/search', ['model' => $searchModel, 'tags' => $tags]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            
            ['attribute' => 'id', 'label' => '#'],

            ['class' => 'app\widgets\grid\ImageColumn'],
            
            'name',
            'email:email',
            ['attribute' => 'typeName', 'label' => Yii::t('app', 'Type')],
            ['attribute' => 'statusName', 'label' => Yii::t('app', 'Status')],
            // 'country_id',
            // 'state_id',
            // 'state',
            // 'city',
            // 'address',
            // 'church_id',
            // 'volunteer',
            // 'candidate',
            // 'notes:ntext',
            // 'created_at',
            // 'updated_at',

            ['class' => 'app\widgets\grid\ActionColumn'],
        ],
    ]); ?>

</div>
