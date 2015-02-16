<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridView;
use app\widgets\ActionsDropdown;

$this->title = Yii::t('app', 'Printing templates');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-index">

    <div class="pull-right">
        <div class="btn-group">
            <?= Html::a(Yii::t('app', 'Create template'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <?= ActionsDropdown::widget([
            'layout' => 'info',
            'items' => [
                ['label' => __('Delete selected'), 'url' => Url::to(['delete']), 'linkOptions' => [
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

    <?= $this->render('components/search', ['model' => $searchModel]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            'id',
            'name',
            ['attribute' => 'formatName', 'label' => __('Format')],
            ['attribute' => 'statusName', 'label' => __('Status')],
            'created_at:date',
            'updated_at:date',

            ['class' => 'app\widgets\grid\ActionColumn'],
        ],
    ]); ?>

</div>