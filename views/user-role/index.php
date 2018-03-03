<?php

use app\models\AuthAssignment;
use app\models\AuthItem;
use app\widgets\grid\ActionColumn;
use app\widgets\grid\CounterColumn;
use app\widgets\grid\GridView;
use app\widgets\ActionsDropdown;
use app\helpers\Url;

/** @var \app\models\search\AuthItemSearch $searchModel */
/** @var \yii\data\ActiveDataProvider $dataProvider */

$this->title = __('User roles');
$this->params['breadcrumbs'][] = $this->title;

$detailsLink = function(AuthItem $model) {
    return [
        'label' => __('Edit'),
        'class' => 'app-modal',
        'href' => Url::to(['/user-role/update', 'id' => $model->name], false, true),
        'data-target-id' => 'user-role_' . $model->name,
    ];
};

$showObjectsCount = function ($objects, $checkAll = true, $type = 'primary') {
    if (!empty($objects)) {
        if ($checkAll && in_array('all', $objects)) {
            return Html::tag('span', __('All'), ['class' => 'label label-warning']);
        } else {
            return Html::tag('span', count($objects), ['class' => 'label label-' . $type]);
        }
    }
};

$usersCount = AuthAssignment::find()->getUsersCount();

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

    <?= $this->render('components/search', ['model' => $searchModel]); ?>


    <?php $this->beginBlock('gridCustomHeader'); ?>
    <tr class="va-middle">
        {column1}
        {column2}
        {column3}
        {column5}
        {column7}
        {column9}
        {column10}

    </tr>
    <tr class="va-middle">
        <?php $this->beginBlock('gridCurrentHeader'); ?>
        <th align="right" class="narrow pre-connected-column" data-toggle="tooltip" data-container="body" data-placement="bottom" title="<?= __("Current") ?>">
            <?= __('Cur.') ?>
        </th>
        <?php $this->endBlock(); ?>
        <?php $this->beginBlock('gridInheritHeader'); ?>
        <th align="left" class="narrow connected-column" data-toggle="tooltip" data-container="body" data-placement="bottom" title="<?= __("Inherited") ?>">
            <?= __('Inh.') ?>
        </th>
        <?php $this->endBlock(); ?>
        <?= $this->blocks['gridCurrentHeader'] ?>
        <?= $this->blocks['gridInheritHeader'] ?>
        <?= $this->blocks['gridCurrentHeader'] ?>
        <?= $this->blocks['gridInheritHeader'] ?>
        <?= $this->blocks['gridCurrentHeader'] ?>
        <?= $this->blocks['gridInheritHeader'] ?>

    </tr>
    <?php $this->endBlock(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-hover table-bordered table-highlighted app-float-thead'],
        'customHeader' => $this->blocks['gridCustomHeader'],
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'headerOptions' => ['rowspan' => 2],
            ],
            [
                'attribute' => 'description',
                'label' => __('Name'),
                'link' => $detailsLink,
                'headerOptions' => ['rowspan' => 2],
            ],

            // Permissions

            [
                'label' => __('Permissions'),
                'value' => function (AuthItem $model) use ($showObjectsCount) {
                    return $showObjectsCount($model->getPermissions(), false);
                },
                'format' => 'raw',
                'headerOptions' => [
                    'align'          => 'center',
                    'colspan'        => 2,
                    'data-toggle'    => "tooltip",
                    'data-container' => "body",
                    'data-placement' => "bottom",
                    'title' => __('Permissions')
                ],
                'contentOptions' => ['align' => 'right', 'class' => 'pre-connected-column'],
            ],
            [
                'value' => function (AuthItem $model) use ($showObjectsCount) {
                    return $showObjectsCount($model->getPermissionsInherited(), false);
                },
                'format' => 'raw',
                'contentOptions' => ['align' => 'left', 'class' => 'connected-column'],
            ],

            // Inherited roles

            [
                'label' => __('Inherited roles'),
                'value' => function (AuthItem $model) use ($showObjectsCount) {
                    return $showObjectsCount($model->getRoles(), false, 'info');
                },
                'format' => 'raw',
                'headerOptions' => [
                    'align'          => 'center',
                    'colspan'        => 2,
                    'data-toggle'    => "tooltip",
                    'data-container' => "body",
                    'data-placement' => "bottom",
                    'title' => __('Inherited roles')
                ],
                'contentOptions' => ['align' => 'right', 'class' => 'pre-connected-column'],
            ],
            [
                'value' => function (AuthItem $model) use ($showObjectsCount) {
                    return $showObjectsCount($model->getRolesInherited(), false, 'info');
                },
                'format' => 'raw',
                'contentOptions' => ['align' => 'left', 'class' => 'connected-column'],
            ],

            // Public tags

            [
                'label' => __('Public tags'),
                'value' => function (AuthItem $model) use ($showObjectsCount) {
                    return $showObjectsCount($model->getObjects('public_tags'), true, 'success');
                },
                'format' => 'raw',
                'headerOptions' => [
                    'align'          => 'center',
                    'colspan'        => 2,
                    'data-toggle'    => "tooltip",
                    'data-container' => "body",
                    'data-placement' => "bottom",
                    'title' => __('Public tags')
                ],
                'contentOptions' => ['align' => 'right', 'class' => 'pre-connected-column'],
            ],
            [
                'value' => function (AuthItem $model) use ($showObjectsCount) {
                    return $showObjectsCount($model->getObjectsInherited('public_tags'), true, 'success');
                },
                'format' => 'raw',
                'contentOptions' => ['align' => 'left', 'class' => 'connected-column'],
            ],

            // Users

            [
                'class' => CounterColumn::class,
                'label' => __('Users'),
                'showEmpty' => false,
                'count' => function(AuthItem $model) use ($usersCount) {
                    if (empty($model->data['system'])) {
                        return isset($usersCount[$model->name]) ? $usersCount[$model->name] : 0;
                    }
                },
                'link' => function(AuthItem $model) {
                    return Url::to(['user/index', 'user_role_id' => $model['name']]);
                },
                'headerOptions' => ['align' => 'center', 'rowspan' => 2],
                'contentOptions' => ['align' => 'center'],
            ],

            // Tools

            [
                'class' => ActionColumn::class,
                'size' => 'xs',
                'items' => [
                    $detailsLink,
                    function(AuthItem $model) {
                        if (Yii::$app->user->can('user_role_manage') && $model->status != AuthItem::STATUS_SYSTEM) {
                            return [
                                'label' => __('Delete'),
                                'href' => Url::to(['delete', 'id' => $model->name], false, true),
                                'data-method' => 'post',
                                'data-confirm' => __('Are you sure you want to delete this item?'),
                            ];
                        }
                    },
                ],
                'headerOptions' => ['rowspan' => 2],
            ],

        ],
        'rowOptions'   => function (AuthItem $model) {
            if ($model->status == AuthItem::STATUS_SYSTEM) {
                return ['class' => 'bg-success'];
            } elseif ($model->status == AuthItem::STATUS_HIDDEN) {
                return ['class' => 'status-disabled'];
            }
            return [];
        },
    ]); ?>

</div>
