<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActionsDropdown;
use app\widgets\Modal;

$this->title = Yii::t('app', 'Donates');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="donate-index">

    <div class="pull-right">
        <div class="btn-group">
            <?= Html::a(Yii::t('app', 'Create donate'), ['update', '_return_url' => Url::to()], [
                'class' => 'btn btn-success c-modal',
                'data-target-id' => 'donate_create',
            ]) ?>
        </div>
        
        <?= ActionsDropdown::widget([
            'layout' => 'info',
            'items' => [
                ['label' => __('Delete selected'), 'url' => Url::to(['delete']), 'linkOptions' => [
                    'data-c-process-items' => 'ids',
                    'data-confirm' => __('Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                ]],
                ['label' => __('Export selected'), 'url' => Url::to(['/export/index', 'object' => 'donates']), 'linkOptions' => [
                    'data-c-process-items' => 'ids',
                ]],
                // ['label' => 'TODO 2', 'url' => '#'],
                // '<li role="presentation" class="divider"></li>',
            ],
        ]) ?>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('components/search', ['model' => $searchModel]) ?>

    <?= $this->render('components/grid', ['dataProvider' => $dataProvider]) ?>

</div>
