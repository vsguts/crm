<?php

use common\models\MailingList;
use common\models\MailingListPartner;
use common\widgets\ActionsDropdown;
use common\widgets\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var \yii\data\ActiveDataProvider $dataProvider */
/** @var \common\models\search\MailingListSearch $searchModel */

$this->title = __('Mailing lists');
$this->params['breadcrumbs'][] = $this->title;

$detailsLink = function($model) {
    return [
        'label' => __('Edit'),
        'href' => Url::to(['/mailing-list/update', 'id' => $model->id]),
    ];
};

$partnerCount = MailingListPartner::find()
    ->andWhere(['list_id' => $dataProvider->getKeys()])
    ->countByColumn('list_id');


?>
<div class="mailing-list-index">

    <?php if (Yii::$app->user->can('mailing_list_manage')) : ?>

    <div class="pull-right buttons-container">
        <div class="btn-group">
            <?= Html::a(__('Create mailing list'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <?= ActionsDropdown::widget([
            'layout' => 'info',
            'items' => [
                ['label' => __('Delete'), 'url' => Url::to(['delete']), 'linkOptions' => [
                    'data-app-process-items' => 'ids',
                    'data-confirm' => __('Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                ]],
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
            'from_email:email',
            [
                'attribute' => 'status',
                'value' => function(MailingList $model, $key, $index, $column){
                    return $model->getLookupItem('status', $model->status);
                }
            ],
            [
                'class' => 'common\widgets\grid\CounterColumn',
                'label' => __('Partners'),
                'count' => function(MailingList $model) use ($partnerCount) {
                    return $partnerCount[$model->id] ?? null;
                },
            ],

            [
                'class' => 'common\widgets\grid\ActionColumn',
                'size' => 'xs',
                'items' => [
                    $detailsLink,
                    function($model) {
                        if (Yii::$app->user->can('mailing_list_manage')) {
                            return [
                                'label' => __('Delete'),
                                'href' => Url::to(['mailing-list/delete', 'id' => $model->id, '_return_url' => Url::to()]),
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
