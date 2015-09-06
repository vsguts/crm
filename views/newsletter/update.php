<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActionsDropdown;

$this->title = Yii::t('app', 'Newsletter: {newsletter}', [
    'newsletter' => $model->subject,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Newsletters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->subject;

?>
<div class="newsletter-update">

    <div class="pull-right buttons-container">
        <?php
            $items = [
                [
                    'label' => __('Send'),
                    'url' => Url::to(['send', 'id' => $model->id]),
                    'linkOptions' => [
                        'data-confirm' => __('Are you sure you want to proceed?'),
                        'data-method' => 'post',
                    ]
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
            'form' => 'newsletter_form',
            'class' => 'btn btn-primary',
        ]) ?>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
        'logSearch' => $logSearch,
    ]) ?>

</div>
