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

    echo $form->field($model, 'partner_id')->textInput();

    echo $form->field($model, 'user_id')->textInput();

    echo $form->field($model, 'name')->textInput(['maxlength' => 255]);

    echo $form->field($model, 'template')->textarea(['rows' => 6]);

    if (!$model->isNewRecord) {
        echo $form->field($model, 'created_at')->widget('app\widgets\Text', ['formatter' => 'date']);

        echo $form->field($model, 'updated_at')->widget('app\widgets\Text', ['formatter' => 'date']);
    }

    echo ButtonsContatiner::widget(['model' => $model]);

    ActiveForm::end();

?>

</div>
