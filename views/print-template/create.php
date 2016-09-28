<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActionsDropdown;

$this->title = __('Create template');
$this->params['breadcrumbs'][] = ['label' => __('Printing templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-create">

    <div class="pull-right buttons-container">
        <?php
            echo Html::submitButton(__('Create'), [
                'form' => 'print_template_form',
                'class' => 'btn btn-success',
            ]);
        ?>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/form', [
        'model' => $model,
    ]) ?>

</div>
