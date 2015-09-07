<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridView;
use app\widgets\ActionsDropdown;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\NewsletterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Newsletters');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="newsletter-index">

    <div class="pull-right buttons-container">
        <div class="btn-group">
            <?= Html::a(Yii::t('app', 'Create newsletter'), ['create'], ['class' => 'btn btn-success']) ?>
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
    
    <?= $this->render('components/search', ['model' => $searchModel]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            ['attribute' => 'id', 'label' => '#'],
            'subject',
            // 'body:ntext',
            'created_at:date',
            'updated_at:date',

            ['class' => 'app\widgets\grid\CounterColumn', 'label' => __('Mailing lists'), 'countField' => 'mailingListsCount'],
            ['class' => 'app\widgets\grid\CounterColumn', 'label' => __('Logs'), 'countField' => 'logsCount'],

            ['class' => 'app\widgets\grid\ActionColumn', 'size' => 'xs'],
        ],
    ]); ?>

</div>
