<?php

use app\widgets\form\ActiveForm;
use app\widgets\Modal;

/** @var \app\components\import\AbstractImport $model */
/** @var array $formatters */

$form_id = 'import_form';

Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'header' => __('Import'),
    'id' => 'import',
    'footer' => Html::submitButton(__('Import'), ['class' => 'btn btn-success', 'form' => $form_id]),
]);

$form = ActiveForm::begin(['options' => ['id' => $form_id, 'enctype' => 'multipart/form-data']]);


echo $this->render('import/objects/' . $model->viewPath, [
    'form' => $form,
    'model' => $model,
    'formatters' => $formatters
]);


echo $form->field($model, 'upload')->fileInput();

ActiveForm::end();

Modal::end();
