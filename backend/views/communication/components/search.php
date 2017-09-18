<?php

use common\models\User;
use common\widgets\form\DatePickerRange;
use common\widgets\form\SearchForm;

/** @var \common\models\search\CommunicationSearch $model */

?>

<div class="communication-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'partner_id')->widget('common\widgets\form\Select2', [
                'url' => ['partner/list'],
                'initValueText' => $model->partner ? $model->partner->extendedName : '',
            ]); ?>

            <?= $form->field($model, 'user_id')->dropDownList(User::find()->permission()->scroll(['empty' => true])) ?>

            <?= $form->field($model, 'timestamp')->widget(DatePickerRange::className()) ?>

        </div>
        <div class="col-md-6">

            <?= $form->field($model, 'type')->dropDownList($model->getLookupItems('type', ['empty' => true])) ?>

            <?= $form->field($model, 'notes') ?>

        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
