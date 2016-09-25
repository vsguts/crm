<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActiveForm;
use app\widgets\ButtonsContatiner;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => __('Export'), 'url' => ['export/index', 'object' => 'partners']];
$this->params['breadcrumbs'][] = $model->name;


$form = ActiveForm::begin();

if ($model->ids) {
    echo $form->field($model, 'ids')->textInput(['disabled' => true]);
    echo Html::activeHiddenInput($model, 'ids');
}

echo $form->field($model, 'fields')->checkboxList($model->availableFields);

echo $form->field($model, 'formatter')->dropDownList($formatters, [
    'class' => 'app-dtoggle app-dtoggle-formatter form-control'
]);

$csv_fields = [
    $form->field($model, 'delimiter')->dropDownList($model->availableDelimiters)
];
echo Html::tag('div', implode(' ', $csv_fields), [
    'class' => 'app-dtoggle-formatter-csv h'
]);

echo $form->field($model, 'filename');

echo '<div class="form-group panel-footer">';

echo Html::submitButton(__('Export'), ['class' => 'btn btn-success']);

echo '</div>';

ActiveForm::end();

?>

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
