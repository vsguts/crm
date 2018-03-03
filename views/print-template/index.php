<?php

use app\models\PrintTemplate;
use app\models\PrintTemplateMailingList;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridView;
use app\widgets\ActionsDropdown;

/** @var \yii\data\ActiveDataProvider $dataProvider */
/** @var \app\models\search\PrintTemplateSearch $searchModel */

$this->title = __('Printing templates');
$this->params['breadcrumbs'][] = $this->title;

$detailsLink = function($model) {
    return [
        'label' => __('Edit'),
        'href' => Url::to(['/print-template/update', 'id' => $model->id]),
    ];
};

$mailingListCount = PrintTemplateMailingList::find()
    ->permission()
    ->andWhere(['template_id' => $dataProvider->getKeys()])
    ->countByColumn('template_id');

?>
<div class="template-index">

    <?php if (Yii::$app->user->can('print_template_manage')) : ?>

    <div class="pull-right buttons-container">
        <div class="btn-group">
            <?= Html::a(__('Create template'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <?= ActionsDropdown::widget([
            'layout' => 'info',
            'items' => [
                ['label' => __('Delete'), 'url' => Url::to(['delete']), 'linkOptions' => [
                    'data-app-process-items' => 'ids',
                    'data-confirm' => __('Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                ]],
                // ['label' => 'TODO 2', 'url' => '#'],
                // '<li role="presentation" class="divider"></li>',
            ],
        ]) ?>
    </div>

    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/search', ['model' => $searchModel]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            [
                'attribute' => 'name',
                'link' => $detailsLink,
            ],
            [
                'attribute' => 'format',
                'value' => function($model, $key, $index, $column){
                    return $model->getLookupItem('format', $model->format);
                }
            ],
            [
                'attribute' => 'status',
                'value' => function($model, $key, $index, $column){
                    return $model->getLookupItem('status', $model->status);
                }
            ],
            'updated_at:date',

            [
                'class' => 'app\widgets\grid\CounterColumn',
                'label' => __('Mailing lists'),
                'count' => function (PrintTemplate $model) use ($mailingListCount) {
                    return $mailingListCount[$model->id] ?? 0;
                },
                'contentOptions' => ['align' => 'center'],
                'headerOptions' => ['align' => 'center'],
            ],

            [
                'class' => 'app\widgets\grid\ActionColumn',
                'size' => 'xs',
                'items' => [
                    $detailsLink,
                    function($model) {
                        if (Yii::$app->user->can('print_template_manage')) {
                            return [
                                'label' => __('Delete'),
                                'href' => Url::to(['print-template/delete', 'id' => $model->id, '_return_url' => Url::to()]),
                                'data-method' => 'post',
                                'data-confirm' => __('Are you sure you want to delete this item?'),
                            ];
                        }
                    },
                ],
            ],
        ],
    ]); ?>

</div>
