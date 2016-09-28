<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActionsDropdown;

$this->title = Yii::t('app', 'Donates');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="donate-index">

    <div class="pull-right buttons-container">
        <?php if (Yii::$app->user->can('donate_manage')) : ?>
            <div class="btn-group">
                <?= Html::a(Yii::t('app', 'Create donate'), ['update', '_return_url' => Url::to()], [
                    'class' => 'btn btn-success app-modal',
                    'data-target-id' => 'donate_create',
                ]) ?>
            </div>
        <?php endif; ?>
        
        <?php 
            $items = [];
            if (Yii::$app->user->can('donate_manage')) {
                $items[] = [
                    'label' => __('Delete'),
                    'url' => Url::to(['delete']),
                    'linkOptions' => [
                        'data-app-process-items' => 'ids',
                        'data-confirm' => __('Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                    ]
                ];
            }
            $items[] = [
                'label' => __('Export'),
                'url' => Url::to(['/export/index', 'object' => 'donates']),
                'linkOptions' => [
                    'data-app-process-items' => 'ids',
                ]
            ];
            echo ActionsDropdown::widget([
                'layout' => 'info',
                'items' => $items,
            ]);
        ?>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('components/search', ['model' => $searchModel]) ?>

    <?= $this->render('components/grid', ['dataProvider' => $dataProvider]) ?>

</div>
