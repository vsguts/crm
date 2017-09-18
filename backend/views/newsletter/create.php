<?php

use yii\helpers\Html;

$this->title = __('Create newsletter');
$this->params['breadcrumbs'][] = ['label' => __('E-mail newsletters'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="newsletter-create">

    <div class="pull-right buttons-container">
        <?php
            echo Html::submitButton(__('Create'), [
                'form' => 'newsletter_form',
                'class' => 'btn btn-success',
            ]);
        ?>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
