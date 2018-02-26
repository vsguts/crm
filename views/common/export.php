<?php

/** @var \app\models\export\ExportFormAbstract $model */

use app\widgets\form\ActiveForm;
use app\widgets\Modal;
use yii\bootstrap\Html;

$form_id = 'export_form';

Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'header' => __('Export'),
    'id' => 'export',
    'footer' => Html::submitButton(__('Export'), ['class' => 'btn btn-success', 'form' => $form_id]),
]);

$form = ActiveForm::begin([
    'options' => [
        'id' => $form_id,
        'data-app-modal' => 'export'
    ],
]);
if ($model->enableAjax) {
    Html::addCssClass($form->options['class'], 'app-ajax');
}

echo Html::input('hidden', 'export_form', 1);

if ($model->ids) {
    foreach ((array)$model->ids as $id) {
        echo Html::input('hidden', 'ids[]', $id);
    }
}

echo $form->field($model, 'formatter')->dropDownList($model->getAvailableFormatters(), [
    'class' => 'form-control',
    'data-app-dtoggle' => 'formatter',
]);

$csvFields = $form->field($model, 'delimiter')->dropDownList($model->getAvailableDelimiters());
echo Html::tag('div', $csvFields, [
    'class' => 'h',
    'data-app-dtoggle-name' => 'formatter',
    'data-app-dtoggle-value' => 'app\components\export\formatter\Csv',
]);

echo $form->field($model, 'filename');


ActiveForm::end();

Modal::end();
