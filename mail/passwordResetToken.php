<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>

<?= __('Hello {name}', [
    '{name}' => $user->username
]) ?>!

<?= __('Follow the link below to reset your password') ?>:

<?= Html::a(Html::encode($resetLink), $resetLink) ?>
