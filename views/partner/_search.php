<?php

use yii\helpers\Html;
use yii\helpers\Url;
// use yii\widgets\ActiveForm;
// use yii\bootstrap\ActiveForm;
use kartik\widgets\ActiveForm;
use app\widgets\Tags;

?>

<div class="partner-search">
    
    <div class="panel panel-info">
        <div class="panel-heading m-toggle m-toggle-save pointer" id="sw_search_form">
            <?=__('Search')?>
        </div>
        <div class="panel-body h" id="search_form">

        <div class="panel panel-default">
            <div class="panel-heading m-toggle m-toggle-save pointer" id="sw_search_form_1">
                <?=__('Tags')?>
            </div>
            <div class="panel-body h" id="search_form_1">
            <ul class="nav nav-pills">
                <?php foreach ($tags as $list_name => $tag_list) : ?>
                    <?php foreach ($tag_list as $tag) : ?>
                        <?php $class = (isset($_REQUEST['PartnerSearch']['tag_id']) && $_REQUEST['PartnerSearch']['tag_id'] == $tag->id) ? 'active' : '' ?>
                        <li role="presentation" class="<?= $class ?>">
                            <a href="<?= Url::to(['partner/index', 'PartnerSearch[tag_id]' => $tag->id]) ?>"><?= $tag->name ?> <span class="badge"><?= $tag->partnersCount ?></span></a>
                        </li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
            </div>
        </div>

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            // 'layout' => 'vertical',
            // 'type' => ActiveForm::TYPE_HORIZONTAL,
        ]); ?>

            
        <?= $form->field($model, 'publicTags')->widget(Tags::classname(), ['placeholder_from_label' => 1]); ?>
        
        <?= $form->field($model, 'personalTags')->widget(Tags::classname(), ['placeholder_from_label' => 1]); ?>

        <?= $form->field($model, 'type')->dropDownList($model->getLookupItems('type', true)) ?>

        <?= $form->field($model, 'status')->dropDownList($model->getLookupItems('status', true)) ?>

        <?= $form->field($model, 'name') ?>

        <?= $form->field($model, 'firstname') ?>

        <?= $form->field($model, 'lastname') ?>

        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'country_id') ?>

        <?= $form->field($model, 'state_id') ?>

        <?= $form->field($model, 'state') ?>

        <?= $form->field($model, 'city') ?>

        <?= $form->field($model, 'address') ?>

        <?= $form->field($model, 'church_id') ?>

        <?= $form->field($model, 'volunteer') ?>

        <?= $form->field($model, 'candidate') ?>

        <?= $form->field($model, 'notes') ?>

        <?= $form->field($model, 'created_at') ?>

        <?= $form->field($model, 'updated_at') ?>

        <div class="panel-footer">

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
            </div>

        </div>

        <?php ActiveForm::end(); ?>
    
        </div>
    </div>

</div>
