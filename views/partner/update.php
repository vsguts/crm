<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActionsDropdown;

$this->title = Yii::t('app', 'Partner: {partner}', [
    'partner' => $model->name,
]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Partners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>
<div class="partner-update">

    <div class="pull-right partner-thumbnail">
        <img src="<?= $model->image->getUrl('80x80') ?>" alt="" />
    </div>

    <div class="pull-right buttons-container">
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
            ];
            echo ActionsDropdown::widget([
                'items' => $items,
            ]);
        ?>
        <?= Html::submitButton(__('Update'), [
            'form' => 'partner_form',
            'class' => 'btn btn-primary',
        ]) ?>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
        'extra' => $extra,
    ]) ?>

</div>
