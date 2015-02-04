
<?= $form->field($model, 'type')->dropDownList($model->getLookupItems('type'), ['class' => 'm-dtoggle m-dtoggle-type form-control']) ?>

<div class="m-dtoggle-type-1 m-dtoggle-type-2 <?= $model->type == 3 ? 'h' : '' ?>">
    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>
</div>

<div class="m-dtoggle-type-3 <?= $model->type != 3 ? 'h' : '' ?>">
    <?= $form->field($model, 'firstname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => 255]) ?>
</div>

<?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

<div class="m-dtoggle-type-3 <?= $model->type != 3 ? 'h' : '' ?>">
    <?= $form->field($model, 'church_id')->dropDownList($model->getList('Partner', 'name', ['scope' => 'churches', 'empty' => true])) ?>

    <?= $form->field($model, 'volunteer')->checkbox(['class' => 'checkboxfix'], false) ?>

    <?= $form->field($model, 'candidate')->checkbox(['class' => 'checkboxfix'], false) ?>
</div>

<?= $form->field($model, 'status')->dropDownList($model->getLookupItems('status')) ?>

<?= $form->field($model, 'publicTags')->widget('app\widgets\Tags', []); ?>

<?= $form->field($model, 'personalTags')->widget('app\widgets\Tags', []); ?>

<?= $form->field($model, 'notes')->textarea(['rows' => 6]) ?>

<?php if (!$model->isNewRecord): ?>
    <?= $form->field($model, 'created_at')->widget('app\widgets\Text', ['formatter' => 'date']) ?>

    <?= $form->field($model, 'updated_at')->widget('app\widgets\Text', ['formatter' => 'date']) ?>
<?php endif; ?>
