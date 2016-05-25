<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridView;
use app\widgets\ActionsDropdown;

$this->title = __('User roles');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="pull-right buttons-container">
        <div class="btn-group">
            <?= Html::a(Yii::t('app', 'Create user role'), ['update', '_return_url' => Url::to()], [
                'class' => 'btn btn-success c-modal',
                'data-target-id' => 'user-role_create',
            ]) ?>
        </div>
        <?= ActionsDropdown::widget([
            'layout' => 'info',
            'items' => [
                ['label' => __('Delete'), 'url' => Url::to(['delete']), 'linkOptions' => [
                    'data-app-process-items' => 'ids',
                    'data-confirm' => __('Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                ]],
            ],
        ]) ?>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'controllerId' => 'user-role',
        'detailsLinkPopup' => true,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            ['attribute' => 'description', 'label' => Yii::t('app_conflict', 'Name')],
            ['attribute' => 'name', 'label' => __('Code')],
            // 'name',
            ['class' => 'app\widgets\grid\ActionColumn', 'size' => 'xs'],
        ],
    ]); ?>

</div>
