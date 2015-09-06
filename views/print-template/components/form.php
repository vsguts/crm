<?php

use yii\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;


$form = ActiveForm::begin(['id' => 'print_template_form']);

echo $form->field($model, 'name')->textInput(['maxlength' => 255]);

echo $form->field($model, 'status')->dropDownList($model->getLookupItems('status'));

echo $form->field($model, 'format')->dropDownList($model->getLookupItems('format'));

echo $form->field($model, 'orientation_landscape')->checkbox(['class' => 'checkboxfix'], false);

// Margin fields
Html::beginTag('div', ['class' => 'row']);
foreach (['margin_top', 'margin_bottom', 'margin_left', 'margin_right'] as $field) {
    $field = $form->field($model, $field, ['horizontalCssClasses' => [
        'offset' => 'col-sm-offset-2',
        'label' => 'col-sm-7',
        'wrapper' => 'col-sm-5',
    ]]);
    echo Html::tag('div', $field, ['class' => 'col-sm-3']);
}
Html::endTag('div');

// echo $form->field($model, 'content')->textarea(['rows' => 6]);
echo $form->field($model, 'content')
    ->widget('app\widgets\Wysiwyg')
    ->hint($this->render('hint_content'));

echo $form->field($model, 'wrapper_enabled')->checkbox(['class' => 'checkboxfix m-dtoggle m-dtoggle-wrapper'], false);

$textarea = $form->field($model, 'wrapper')->textarea(['rows' => 6])->hint($this->render('hint_wrapper'));
$css_class = 'm-dtoggle-wrapper-on ' . ($model->wrapper_enabled ? 'h' : '');
echo Html::tag('div', $textarea, ['class' => $css_class]);

echo $form->field($model, 'mailingListIds')->checkboxList($model->getList('MailingList', 'name', ['scope' => 'active']));

if (!$model->isNewRecord) {
    echo $form->field($model, 'created_at')->widget('app\widgets\Text', ['formatter' => 'date']);
    echo $form->field($model, 'updated_at')->widget('app\widgets\Text', ['formatter' => 'date']);
}

ActiveForm::end();

