<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\widgets\ButtonsContatiner;

/* @var $this yii\web\View */
/* @var $model app\models\Template */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="template-form">

<?php

    $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'options' => ['enctype' => 'multipart/form-data'],
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                'offset' => 'col-sm-offset-4',
                'wrapper' => 'col-sm-10',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]);

    echo $form->field($model, 'name')->textInput(['maxlength' => 255]);

    echo $form->field($model, 'status')->dropDownList($model->getLookupItems('status'));

    echo $form->field($model, 'format')->dropDownList($model->getLookupItems('format'));

    echo $form->field($model, 'orientation_landscape')->checkbox(['class' => 'checkboxfix'], false);

    echo $form->field($model, 'margin_top');
    
    echo $form->field($model, 'margin_bottom');
    
    echo $form->field($model, 'margin_left');
    
    echo $form->field($model, 'margin_right');

    // echo $form->field($model, 'content')->textarea(['rows' => 6]);
    echo $form->field($model, 'content')->widget('yii\imperavi\Widget', [
        // Some options, see http://imperavi.com/redactor/docs/
        'options' => [
            'buttonSource' => true,
        ],
        'plugins' => [
            'fullscreen',
            'clips',
            'table',
        ],
    ])->hint($this->render('hint_content'));

    echo $form->field($model, 'wrapper_enabled')->checkbox(['class' => 'checkboxfix m-dtoggle m-dtoggle-wrapper'], false);

    $textarea = $form->field($model, 'wrapper')->textarea(['rows' => 6])->hint($this->render('hint_wrapper'));
    $css_class = 'm-dtoggle-wrapper-on ' . ($model->wrapper_enabled ? 'h' : '');
    echo Html::tag('div', $textarea, ['class' => $css_class]);

    if (!$model->isNewRecord) {
        echo $form->field($model, 'created_at')->widget('app\widgets\Text', ['formatter' => 'date']);

        echo $form->field($model, 'updated_at')->widget('app\widgets\Text', ['formatter' => 'date']);
    }

    echo ButtonsContatiner::widget(['model' => $model]);

    ActiveForm::end();

?>

</div>
