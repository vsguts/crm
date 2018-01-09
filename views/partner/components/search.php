<?php

use app\models\search\PartnerSearch;
use yii\helpers\Html;
use app\models\Country;
use app\widgets\form\SearchForm;

/* @var $model PartnerSearch */

?>

<div class="partner-search">

    <?php $form = SearchForm::begin(); ?>

    <?= $form->field($model, 'q', [
        'template' => '<div class="col-sm-12">{input}{error}{hint}</div>',
        'inputOptions' => [
            'placeholder' => __('Search'),
        ],
    ]) ?>

    <?= Html::activeHiddenInput($model, 'tag_id'); ?>
    
    <div class="panel panel-default">
        <div class="panel-heading app-toggle app-toggle-save pointer" data-target-class="search_form_advanced_search">
            <?=__('Advanced search')?>
        </div>
        <div class="panel-body search_form_advanced_search <?=empty($_COOKIE['app-toggle-search_form_advanced_search'])?'h gvs':''?>">
            <ul class="nav nav-pills">

                <div class="row">
                    <div class="col-md-6">

                        <?= $form->field($model, 'publicTags')->label(__('Publ. tags'))->widget('app\widgets\Tags', ['placeholder_from_label' => 1]); ?>

                        <?= $form->field($model, 'personalTags')->label(__('Pers. tags'))->widget('app\widgets\Tags', ['placeholder_from_label' => 1]); ?>

                        <?= $form->field($model, 'type')->dropDownList($model->getLookupItems('type', ['empty' => true])) ?>

                        <?= $form->field($model, 'name') ?>

                        <?= $form->field($model, 'communication_method')->dropDownList($model->getLookupItems('communication_method', ['empty' => true])) ?>

                    </div>
                    <div class="col-md-6">

                        <?= $form->field($model, 'status')->dropDownList($model->getLookupItems('status', ['empty' => true])) ?>

                        <?= $form->field($model, 'email') ?>

                        <?= $form->field($model, 'email_existence')->dropdownList($model->getBoolItems()) ?>

                        <?= $form->field($model, 'country_id')->dropDownList(Country::find()->scroll(['empty' => true]), ['class' => 'form-control app-country app-country-required']) ?>

                        <?= $form->field($model, 'state_id', ['options' => ['class' => 'form-group h']])->dropDownList(['' => ' -- '], ['data-app-value' => $model->state_id]) ?>

                        <?= $form->field($model, 'state', ['options' => ['class' => 'form-group h']]) ?>

                        <?= $form->field($model, 'city') ?>

                        <?= $form->field($model, 'address') ?>

                    </div>
                </div>
                            
            </ul>
        </div>
    </div>

    <?php SearchForm::end(); ?>

</div>
