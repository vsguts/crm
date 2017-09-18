<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\ActionsDropdown;

$this->title = __('Newsletter: {newsletter}', [
    'newsletter' => $model->subject,
]);

$this->params['breadcrumbs'][] = ['label' => __('E-mail newsletters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->subject;

?>
<div class="newsletter-update">

    <div class="pull-right buttons-container">
    <?php
        if (Yii::$app->user->can('newsletter_manage')) {
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
            echo '&nbsp;';
            echo Html::submitButton(__('Update'), [
                'form' => 'newsletter_form',
                'class' => 'btn btn-primary',
            ]);
        }
    ?>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
        'logSearch' => $logSearch,
    ]) ?>

</div>
