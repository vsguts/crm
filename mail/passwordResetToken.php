<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>

<?= __('Hello {name}', [
    'name' => $user->name ?: $user->email
]) ?>!

<?= __('Follow the link below to reset your password') ?>:

<?= Html::a(Html::encode($resetLink), $resetLink) ?>
