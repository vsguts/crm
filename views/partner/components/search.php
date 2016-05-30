<?php

use yii\helpers\Html;
use app\widgets\SearchForm;

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

                        <?= $form->field($model, 'type')->dropDownList($model->getLookupItems('type', ['empty' => 'label']), ['class' => 'app-dtoggle app-dtoggle-type form-control']) ?>

                        <?= $form->field($model, 'name') ?>

                        <div class="app-dtoggle-type-3">
                            <?=
                                $form->field($model, 'parent_id')->widget('app\widgets\SelectAjax', [
                                    'organizations' => true,
                                    'initValueText' => $model->parent ? $model->parent->extendedName : '',
                                ])
                            ?>

                            <?= $form->field($model, 'volunteer')->checkbox(['uncheck' => ''], false) ?>

                            <?= $form->field($model, 'candidate')->checkbox(['uncheck' => ''], false) ?>
                        </div>

                        <?= $form->field($model, 'created_at')->widget('app\widgets\DatePickerRange') ?>

                        <?= $form->field($model, 'updated_at')->widget('app\widgets\DatePickerRange') ?>

                    </div>
                    <div class="col-md-6">
                        
                        <?= $form->field($model, 'personalTags')->label(__('Pers. tags'))->widget('app\widgets\Tags', ['placeholder_from_label' => 1]); ?>

                        <?= $form->field($model, 'status')->dropDownList($model->getLookupItems('status', ['empty' => 'label'])) ?>

                        <?= $form->field($model, 'email') ?>

                        <?= $form->field($model, 'country_id')->dropDownList($model->getList('Country', 'name', ['empty' => __('Country')]), ['class' => 'form-control app-country app-country-required']) ?>

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
