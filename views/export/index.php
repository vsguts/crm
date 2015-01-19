<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use app\widgets\ButtonsContatiner;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => __('Export'), 'url' => ['export/index', 'object' => 'partners']];
$this->params['breadcrumbs'][] = $model->name;
?>

<div class="export-index">

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

    if ($model->ids) {
        echo $form->field($model, 'ids')->textInput(['disabled' => true]);
        echo Html::activeHiddenInput($model, 'ids');
    }
    
    echo $form->field($model, 'fields')->checkboxList($model->availableFields);
    
    echo $form->field($model, 'delimiter')->dropDownList($model->availableDelimiters);

    echo $form->field($model, 'filename');
    
    echo '<div class="form-group panel-footer">';

    echo Html::submitButton(__('Export'), ['class' => 'btn btn-success']);

    echo '</div>';
    
    ActiveForm::end();
?>

</div>

<?php $this->beginBlock('sidebox'); ?>

    <ul class="nav nav-pills nav-stacked">
        <?php foreach ($objects as $object): ?>
            <?php
                $class = $object->id == $model->id ? 'active' : '';
            ?>
            <li role="presentation" class="<?= $class ?>">
                <a href="<?= Url::to(['export/index', 'object' => $object->id]) ?>"><?= $object->name ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    
<?php $this->endBlock(); ?>
