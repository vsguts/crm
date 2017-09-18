<?php

use common\widgets\grid\ActionColumn;
use common\widgets\grid\CounterColumn;
use common\widgets\grid\GridView;
use common\widgets\ActionsDropdown;

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

$showObjectsCount = function ($model, $object, $type = 'primary') {
    $text = false;
    if (!empty($model['data'][$object])) {
        if (in_array('all', $model['data'][$object])) {
            return Html::tag('span', __('All'), ['class' => 'label label-success']);
        } else {
            return Html::tag('span', count($model['data'][$object]), ['class' => 'label label-' . $type]);
        }
    }
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
        'tableOptions' => ['class' => 'table table-hover table-highlighted app-float-thead'],
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
                'label' => __('Permissions'),
                'value' => function ($model) use ($showObjectsCount) {
                    return $showObjectsCount($model, 'permissions');
                },
                'format' => 'raw',
                'headerOptions' => ['align' => 'center'],
                'contentOptions' => ['align' => 'center'],
            ],
            [
                'label' => __('Inherited roles'),
                'value' => function ($model) use ($showObjectsCount) {
                    return $showObjectsCount($model, 'roles', 'info');
                },
                'format' => 'raw',
                'headerOptions' => ['align' => 'center'],
                'contentOptions' => ['align' => 'center'],
            ],
            [
                'label' => __('Public tags'),
                'value' => function ($model) use ($showObjectsCount) {
                    return $showObjectsCount($model, 'public_tags');
                },
                'format' => 'raw',
                'headerOptions' => ['align' => 'center'],
                'contentOptions' => ['align' => 'center'],
            ],
            [
                'class' => CounterColumn::className(),
                'label' => __('Users'),
                'count' => function($model) {
                    if (empty($model['data']['system'])) {
                        return count(Yii::$app->authManager->getUserIdsByRole($model['name']));
                    }
                },
                'link' => function($model) {
                    return Url::to(['user/index', 'user_role_id' => $model['name']]);
                },
                'headerOptions' => ['align' => 'center'],
                'contentOptions' => ['align' => 'center'],
            ],
            // 'name',
            [
                'class' => ActionColumn::className(),
                'size' => 'xs',
                'items' => [
                    $detailsLink,
                    function($model) {
                        if (Yii::$app->user->can('user_manage') && empty($model['data']['system'])) {
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
        'rowOptions'   => function ($model) {
            if (!empty($model['data']['system'])) {
                return ['class' => 'bg-success'];
            }
            return [];
        },
    ]); ?>

</div>
