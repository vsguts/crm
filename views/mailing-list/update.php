<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActionsDropdown;

/* @var $this yii\web\View */
/* @var $model app\models\MailingList */

$this->title = __('Mailing list: {name}', [
    'name' => $model->name,
]);

$this->params['breadcrumbs'][] = ['label' => __('Mailing lists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="mailing-list-update">

    <div class="pull-right buttons-container">
    <?php
        if (Yii::$app->user->can('newsletter_manage')) {
            $items = [
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
                'form' => 'mailing_list_form',
                'class' => 'btn btn-primary',
            ]);
        }
    ?>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
