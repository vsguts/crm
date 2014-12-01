<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use app\widgets\ActionsDropdown;
use app\widgets\grid\LinkedTextColumn;
use app\widgets\grid\ActionColumn;
use app\widgets\grid\DataColumn;

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="pull-right">
        <div class="btn-group">
            <?= Html::a(Yii::t('app', 'Create user'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <?= ActionsDropdown::widget([
            'layout' => 'info',
            'items' => [
                ['label' => 'TODO 1', 'url' => '/'],
                ['label' => 'TODO 2', 'url' => '#'],
                // '<li role="presentation" class="divider"></li>',
            ],
        ]) ?>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'dataColumnClass' => DataColumn::className(),
        'tableOptions' => [
            'class' => 'table',
        ],
        'columns' => [
            ['class' => CheckboxColumn::className()],

            'id',
            'username',
            'email:email',
            ['attribute' => 'roleName', 'label' => Yii::t('app', 'Role')],
            ['attribute' => 'statusName', 'label' => Yii::t('app', 'Status')],
            'firstname',
            'lastname',
            // 'country_id',
            // 'state_id',
            // 'state',
            // 'city',
            // 'address',
            // 'created_at',
            // 'updated_at',

            ['class' => ActionColumn::className(), 'size' => 'xs'],
        ],
    ]); ?>

</div>
