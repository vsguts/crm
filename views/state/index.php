<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use app\widgets\ActionsDropdown;
use app\widgets\grid\ActionColumn;
use app\widgets\grid\DataColumn;

$this->title = Yii::t('app', 'States');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="state-index">

    <div class="pull-right">
        <div class="btn-group">
            <?= Html::a(Yii::t('app', 'Create state'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <?= ActionsDropdown::widget([
            'layout' => 'info',
            'items' => [
                ['label' => __('Delete selected'), 'url' => Url::to(['delete', 'id' => 0]), 'linkOptions' => [
                    'data-confirm' => __('Are you sure you want to delete selected items?'),
                    'class' => 'm-delete-items',
                ]],
            ],
        ]) ?>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

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
            ['attribute' => 'country.name', 'label' => __('Country')],
            'name',
            'code',

            ['class' => ActionColumn::className()],
        ],
    ]); ?>

</div>
