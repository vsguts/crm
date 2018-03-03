<?php

use app\models\MailingList;
use app\widgets\form\ActiveForm;
use yii\helpers\Html;


$form = ActiveForm::begin(['id' => 'print_template_form']);

echo $form->field($model, 'name')->textInput(['maxlength' => 255]);

echo $form->field($model, 'status')->dropDownList($model->getLookupItems('status'));

echo $form->field($model, 'format')->dropDownList($model->getLookupItems('format'));

echo $form->field($model, 'orientation_landscape')->checkbox(['class' => 'checkboxfix'], false);

echo $form->field($model, 'items_per_page')->textInput([
    'maxlength' => true,
]);

// Margin fields
Html::beginTag('div', ['class' => 'row']);
foreach (['margin_top', 'margin_bottom', 'margin_left', 'margin_right'] as $field) {
    $field = $form
        ->field($model, $field, [
            'horizontalCssClasses' => [
                'offset' => 'col-sm-offset-2',
                'label' => 'col-sm-7',
                'wrapper' => 'col-sm-5',
            ]
        ])
        ->textInput([
            'maxlength' => true,
        ]);
    echo Html::tag('div', $field, ['class' => 'col-sm-3']);
}
Html::endTag('div');

echo $form->field($model, 'content')
    ->hint($this->render('hint_content'))
    ->textarea(['rows' => 6]);
    // ->widget('app\widgets\form\Wysiwyg');

echo $form->field($model, 'wrapper_enabled')->checkbox(['class' => 'checkboxfix app-dtoggle app-dtoggle-wrapper'], false);

$textarea = $form->field($model, 'wrapper')->textarea(['rows' => 6])->hint($this->render('hint_wrapper'));
$css_class = 'app-dtoggle-wrapper-on ' . ($model->wrapper_enabled ? 'h' : '');
echo Html::tag('div', $textarea, ['class' => $css_class]);

echo $form->field($model, 'mailingListIds')->checkboxList(MailingList::find()->active()->scroll());

if (!$model->isNewRecord) {
    echo $form->field($model, 'created_at')->text(['format' => 'date']);
    echo $form->field($model, 'updated_at')->text(['format' => 'date']);
}

ActiveForm::end();

