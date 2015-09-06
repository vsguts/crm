<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridView;
use app\widgets\ActionsDropdown;

$this->title = Yii::t('app', 'States');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="state-index">

    <div class="pull-right buttons-container">
        <div class="btn-group">
            <?= Html::a(Yii::t('app', 'Create state'), ['update', '_return_url' => Url::to()], [
                'class' => 'btn btn-success c-modal',
                'data-target-id' => 'state_create',
            ]) ?>
        </div>
        <?= ActionsDropdown::widget([
            'layout' => 'info',
            'items' => [
                ['label' => __('Delete'), 'url' => Url::to(['delete']), 'linkOptions' => [
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
        'controllerId' => 'state',
        'detailsLinkPopup' => true,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            'id',
            'name',
            ['attribute' => 'country.name', 'label' => __('Country')],
            'code',

            ['class' => 'app\widgets\grid\ActionColumn', 'size' => 'xs'],
        ],
    ]); ?>

</div>
