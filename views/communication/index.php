<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActionsDropdown;

$this->title = __('Communication');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="communication-index">

    <div class="pull-right buttons-container">
        <?php if (Yii::$app->user->can('communication_manage')) : ?>
            <div class="btn-group">
                <?= Html::a(__('Create communication'), ['update', '_return_url' => Url::to()], [
                    'class' => 'btn btn-success app-modal',
                    'data-target-id' => 'communication_create',
                ]) ?>
            </div>
        <?php endif; ?>

        <?php 
            $items = [
                [
                    'label' => __('Export selected'),
                    'url' => Url::to(['export']),
                    'linkOptions' => [
                        'class' => 'app-modal app-modal-force',
                        'data-target-id' => 'export',
                        'data-app-process-items' => 'ids',
                        'data-method' => 'post'
                    ],
                ],
                [
                    'label' => __('Export all'),
                    'url' => Url::to(array_merge(['export'], Yii::$app->request->queryParams)),
                    'linkOptions' => [
                        'class' => 'app-modal app-modal-force',
                        'data-target-id' => 'export',
                    ],
                ],
            ];
            if (Yii::$app->user->can('communication_manage')) {
                $items[] = '<li role="presentation" class="divider"></li>';
                $items[] = [
                    'label' => __('Delete selected'),
                    'url' => Url::to(['delete']),
                    'linkOptions' => [
                        'data-app-process-items' => 'ids',
                        'data-confirm' => __('Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                    ]
                ];
            }
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
