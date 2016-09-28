<?php

use app\widgets\grid\GridView;
use app\widgets\ActionsDropdown;

$this->title = __('User roles');
$this->params['breadcrumbs'][] = $this->title;

$detailsLink = function($model) {
    return [
        'label' => __('Edit'),
        'class' => 'app-modal',
        'href' => Url::to(['/user-role/update', 'id' => $model['id']]),
        'data-target-id' => 'user-role_' . $model['id'],
    ];
};

?>
<div class="user-index">

    <?php if (Yii::$app->user->can('user_role_manage')) : ?>

    <div class="pull-right buttons-container">
        <div class="btn-group">
            <?= Html::a(__('Create user role'), ['update', '_return_url' => Url::to()], [
                'class' => 'btn btn-success app-modal',
                'data-target-id' => 'user-role_create',
            ]) ?>
        </div>
        <?= ActionsDropdown::widget([
            'layout' => 'info',
            'items' => [
                ['label' => __('Delete selected'), 'url' => Url::to(['delete']), 'linkOptions' => [
                    'data-app-process-items' => 'id',
                    'data-confirm' => __('Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                ]],
            ],
        ]) ?>
    </div>

    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn'
            ],
            [
                'attribute' => 'description',
                'label' => __('Name'),
                'link' => $detailsLink,
            ],
            [
                'attribute' => 'name',
                'label' => __('Code')
            ],
            // 'name',
            [
                'class' => 'app\widgets\grid\ActionColumn',
                'size' => 'xs',
                'items' => [
                    $detailsLink,
                    function($model) {
                        if (Yii::$app->user->can('user_manage')) {
                            return [
                                'label' => __('Delete'),
                                'href' => Url::to(['user-role/delete', 'id' => $model['id'], '_return_url' => Url::to()]),
                                'data-method' => 'post',
                                'data-confirm' => __('Are you sure you want to delete this item?'),
                            ];
                        }
                    },
                ],
            ],
        ],
    ]); ?>

</div>
