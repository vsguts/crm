<?php

use app\models\AuthItem;
use app\widgets\form\SearchForm;

/** @var \app\models\search\AuthItemSearch $model */

?>

<div class="user-role-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'description') ?>

            <?= $form->field($model, 'name') ?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'status')->dropDownList($model->getLookupItems('status', ['empty' => true])) ?>

            <?= $form->field($model, 'permission')->dropDownList(AuthItem::find()->getPermissionsGrouped(false), [
                'prompt' => '--',
                'class' => ['form-control', 'app-select2']
            ]) ?>

        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
