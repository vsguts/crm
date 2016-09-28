<?php

use yii\helpers\Html;

$this->title = __('Create user');
$this->params['breadcrumbs'][] = ['label' => __('Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <div class="pull-right buttons-container">
        <?php
            echo Html::submitButton(__('Create'), [
                'form' => 'user_form',
                'class' => 'btn btn-success',
            ]);
        ?>
    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
        'roles' => isset($roles) ? $roles : null,
    ]) ?>

</div>
