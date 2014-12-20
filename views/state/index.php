<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use app\widgets\ActionsDropdown;

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
                ['label' => __('Delete selected'), 'url' => Url::to(['delete']), 'linkOptions' => [
                    'data-c-process-items' => 'ids',
                    'data-confirm' => __('Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                ]],
            ],
        ]) ?>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('components/search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'dataColumnClass' => 'app\widgets\grid\DataColumn',
        'tableOptions' => [
            'class' => 'table',
        ],
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            'id',
            ['attribute' => 'country.name', 'label' => __('Country')],
            'name',
            'code',

            ['class' => 'app\widgets\grid\ActionColumn'],
        ],
    ]); ?>

</div>
