<?php

use app\widgets\ActionsDropdown;

$this->title = __('User: {user}', [
    'user' => $model->name,
]);

$this->params['breadcrumbs'][] = ['label' => __('Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="user-update">

    <div class="pull-right buttons-container">
        <?php if (Yii::$app->user->can('user_manage') || Yii::$app->user->can('user_manage_own', ['user' => $model])) : ?>

        <?php
            $items = [
                [
                    'label' => __('Delete'),
                    'url' => Url::to(['delete', 'id' => $model->id]),
                    'linkOptions' => [
                        'data-confirm' => __('Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                    ]
                ],
                [
                    'label' => __('Act on behalf of'),
                    'url' => Url::to(['act-on-behalf', 'id' => $model->id]),
                    'linkOptions' => [
                        'data-method' => 'post',
                    ]
                ],
            ];
            echo ActionsDropdown::widget([
                'items' => $items,
            ]);
        ?>

        <?= Html::submitButton(__('Update'), [
            'form' => 'user_form',
            'class' => 'btn btn-primary',
        ]) ?>

        <?php endif; ?>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
        'roles' => isset($roles) ? $roles : null,
    ]) ?>

</div>
