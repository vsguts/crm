<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = __('Sign in');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login col-md-4 col-md-offset-4">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                
                <?= $form->field($model, 'email') ?>
                
                <?= $form->field($model, 'password')->passwordInput()->label(__('Password') . ' (' . Html::a(__('Forgot password?'), ['site/request-password-reset'], ['tabindex' => '5']) . ')') ?>
                
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                
                <?= Html::submitButton(__('Sign in'), ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <p class="text-center">
        <a href="<?= Url::to(['site/signup']) ?>"><?= __("Don't have an account? Sign up!") ?></a>
    </p>
    
    </div>
</div>
