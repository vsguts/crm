<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use app\widgets\ActionsDropdown;
use app\widgets\grid\LinkedTextColumn;
use app\widgets\grid\ActionColumn;
use app\widgets\grid\DataColumn;

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
                ['label' => 'TODO 1', 'url' => '/'],
                ['label' => 'TODO 2', 'url' => '#'],
                // '<li role="presentation" class="divider"></li>',
            ],
        ]) ?>
    </div>
    
    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel, 'tags' => $tags]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'dataColumnClass' => DataColumn::className(),
        'tableOptions' => [
            'class' => 'table',
        ],
        'columns' => [
            ['class' => CheckboxColumn::className()],
            
            ['attribute' => 'id', 'label' => '#'],

            'name',
            ['attribute' => 'typeName', 'label' => Yii::t('app', 'Type')],
            ['attribute' => 'statusName', 'label' => Yii::t('app', 'Status')],
            'email:email',
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

            ['class' => ActionColumn::className()],
        ],
    ]); ?>

</div>
