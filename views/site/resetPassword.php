<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title = __('Reset your password');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-reset-password col-md-4 col-md-offset-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= Html::submitButton(__('Finish'), ['class' => 'btn btn-success btn-block']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
