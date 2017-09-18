<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = __('Sign up');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup col-md-4 col-md-offset-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'name') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= Html::submitButton(__('Sign up'), ['class' => 'btn btn-success btn-block', 'name' => 'signup-button']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <p class="text-center">
        <a href="<?= Url::to(['site/login']) ?>"><?= __("Already registered? Sign in!") ?></a>
    </p>

</div>
