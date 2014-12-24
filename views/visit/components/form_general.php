
<?= $form->field($model, 'partner_id')->dropDownList($model->getList('Partner', 'name')) ?>

<?= $form->field($model, 'user_id')->dropDownList($model->getList('User', 'fullname', ['empty_field' => 'username'])) ?>

<?= $form->field($model, 'timestamp')->widget('kartik\date\DatePicker', [
    'options' => ['placeholder' => __('Select date')],
    'pluginOptions' => ['autoclose' => true],
]) ?>

<?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

<?php if (!$model->isNewRecord): ?>
    <?= $form->field($model, 'created_at')->widget('app\widgets\Text', ['formatter' => 'date']) ?>

    <?= $form->field($model, 'updated_at')->widget('app\widgets\Text', ['formatter' => 'date']) ?>
<?php endif; ?>
