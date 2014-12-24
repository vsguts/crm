<?php

use yii\helpers\Html;
use app\widgets\SearchForm;

?>

<div class="user-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'username') ?>

            <?= $form->field($model, 'fullname') ?>

            <?= $form->field($model, 'email') ?>
        
        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'status')->dropDownList($model->getLookupItems('status', ['empty' => 'label'])) ?>

            <?= $form->field($model, 'role')->dropDownList($model->getLookupItems('role', ['empty' => 'label'])) ?>

            <?php // echo $form->field($model, 'created_at') ?>

            <?php // echo $form->field($model, 'updated_at') ?>
    
        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
