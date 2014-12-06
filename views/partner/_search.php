<?php

use yii\helpers\Url;
use app\widgets\SearchForm;
use app\widgets\Tags;

?>

<div class="partner-search">

    <?php $form = SearchForm::begin(); ?>

    <div class="panel panel-default">
        <div class="panel-heading m-toggle m-toggle-save pointer" data-target-class="search_form_1">
            <?=__('Tags')?>
        </div>
        <div class="panel-body h search_form_1">
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
        
    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'publicTags')->label(__('Publ. tags'))->widget(Tags::classname(), ['placeholder_from_label' => 1]); ?>

            <?= $form->field($model, 'type')->dropDownList($model->getLookupItems('type', ['empty' => 'label']), ['class' => 'm-dtoggle m-dtoggle-type']) ?>

            <?= $form->field($model, 'name') ?>

            <div class="m-dtoggle-type-3">
                <?= $form->field($model, 'church_id') ?>

                <?= $form->field($model, 'volunteer')->checkbox(['uncheck' => ''], false) ?>

                <?= $form->field($model, 'candidate')->checkbox(['uncheck' => ''], false) ?>
            </div>

        </div>
        <div class="col-md-6">
            
            <?= $form->field($model, 'personalTags')->label(__('Pers. tags'))->widget(Tags::classname(), ['placeholder_from_label' => 1]); ?>

            <?= $form->field($model, 'status')->dropDownList($model->getLookupItems('status', ['empty' => 'label'])) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'country_id')->dropDownList($model->getList('Country', 'name', ['empty' => __('Country')]), ['class' => 'form-control m-country']) ?>

            <?= $form->field($model, 'state_id')->dropDownList(['' => ' -- '], ['data-c-value' => $model->state_id]) ?>

            <?= $form->field($model, 'state') ?>

            <?= $form->field($model, 'city') ?>

            <?= $form->field($model, 'address') ?>

        </div>
        
    </div>

    <?php SearchForm::end(); ?>

</div>
