<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = __('Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="setting-index">

    <?php if (Yii::$app->user->can('setting_manage')) : ?>

    <div class="pull-right buttons-container">
        <?= Html::submitButton(__('Update'), [
            'form' => 'settings_form',
            'class' => 'btn btn-primary',
        ]) ?>
    </div>

    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
