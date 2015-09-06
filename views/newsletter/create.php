<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Newsletter */

$this->title = Yii::t('app', 'Create newsletter');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Newsletters'), 'url' => ['index']];
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
