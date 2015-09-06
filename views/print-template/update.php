<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActionsDropdown;

$this->title = Yii::t('app', 'Printing template: {template}', [
    'template' => $model->name,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Printing templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;

?>
<div class="template-update">

    <div class="pull-right buttons-container">
        <?php
            $items = [
                [
                    'label' => __('Print'), 'url' => Url::to(['view', 'id' => $model->id]),
                ],
                [
                    'label' => __('Delete'),
                    'url' => Url::to(['delete', 'id' => $model->id]),
                    'linkOptions' => [
                        'data-confirm' => __('Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                    ]
                ],
            ];
            echo ActionsDropdown::widget([
                'items' => $items,
            ]);
        ?>
        <?= Html::submitButton(__('Update'), [
            'form' => 'print_template_form',
            'class' => 'btn btn-primary',
        ]) ?>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
