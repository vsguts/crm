<?php

use common\widgets\grid\GridView;
use common\widgets\ActionsDropdown;

$this->title = __('Users');
$this->params['breadcrumbs'][] = $this->title;

$detailsLink = function($model) {
    return [
        'label' => __('Edit'),
        'href' => Url::to(['/user/update', 'id' => $model->id, '_return_url' => Url::to()]),
        'class' => 'app-modal',
        'data-target-id' => 'user_' . $model->id,
    ];
};

?>
<div class="user-index">

    <?php if (Yii::$app->user->can('user_manage')) : ?>

    <div class="pull-right buttons-container">
        <div class="btn-group">
            <?= Html::a(__('Create user'), ['update', '_return_url' => Url::to()], [
                'class' => 'btn btn-success app-modal',
                'data-target-id' => 'user_create',
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
                // ['label' => 'TODO 2', 'url' => '#'],
                // '<li role="presentation" class="divider"></li>',
            ],
        ]) ?>
    </div>

    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('components/search', ['model' => $searchModel, 'permissions' => $permissions]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            // ['attribute' => 'id', 'label' => '#'],
            [
                'attribute' => 'name',
                'link' => $detailsLink,
            ],
            'email',
            [
                'attribute' => 'status',
                'value' => function($model, $key, $index, $column){
                    return $model->getLookupItem('status', $model->status);
                }
            ],
            // 'created_at',
            // 'updated_at',

            [
                'class' => 'common\widgets\grid\ActionColumn',
                'size' => 'xs',
                'items' => [
                    $detailsLink,
                    function($model) {
                        if (Yii::$app->user->can('user_manage')) {
                            return [
                                'label' => __('Delete'),
                                'href' => Url::to(['user/delete', 'id' => $model->id, '_return_url' => Url::to()]),
                                'data-method' => 'post',
                                'data-confirm' => __('Are you sure you want to delete this item?'),
                            ];
                        }
                    },
                    function($model) {
                        if (Yii::$app->user->can('user_act_on_behalf')) {
                            return [
                                'label' => __('Act on behalf of'),
                                'href' => Url::to(['user/act-on-behalf', 'id' => $model->id]),
                                'data-method' => 'post',
                            ];
                        }
                    },
                    '<li role="presentation" class="divider"></li>',
                    function($model) {
                        return [
                            'label' => __('Direct link'),
                            'href' => Url::to(['/user/index', 'id' => $model->id, '#' => 'user_' . $model->id]),
                            'target' => '_blank',
                        ];
                    },
                ],
            ],
        ],
        'rowOptions' => function($model) {
            return [
                'class' => 'status-' . $model->status,
            ];
        },
    ]); ?>

</div>
