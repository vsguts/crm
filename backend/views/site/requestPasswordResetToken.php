<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

$this->title = __('Recover your password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset col-md-4 col-md-offset-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email') ?>

                <?= Html::submitButton(__('Continue'), ['class' => 'btn btn-primary btn-block']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
