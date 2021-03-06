<?php

use app\models\MailingList;
use app\models\MailingListPartner;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridView;
use app\widgets\ActionsDropdown;

/** @var \yii\data\ActiveDataProvider $dataProvider */

$this->title = __('Mailing lists');
$this->params['breadcrumbs'][] = $this->title;

$detailsLink = function($model) {
    return [
        'label' => __('Edit'),
        'href' => Url::to(['/mailing-list/update', 'id' => $model->id]),
    ];
};

$counts = MailingListPartner::find()
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
            'from_email:email',
            [
                'attribute' => 'status',
                'value' => function($model, $key, $index, $column){
                    return $model->getLookupItem('status', $model->status);
                }
            ],
            [
                'class' => 'app\widgets\grid\CounterColumn',
                'label' => __('Partners'),
                'count' => function(MailingList $model) use ($counts) {
                    return $counts[$model->id] ?? 0;
                },
                'headerOptions' => ['align' => 'center'],
                'contentOptions' => ['align' => 'center'],
            ],

            [
                'class' => 'app\widgets\grid\ActionColumn',
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
