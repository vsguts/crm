<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridView;
use app\widgets\ActionsDropdown;

$this->title = __('Newsletters');
$this->params['breadcrumbs'][] = $this->title;

$detailsLink = function($model) {
    return [
        'label' => __('Edit'),
        'href' => Url::to(['/newsletter/update', 'id' => $model->id, '_return_url' => Url::to()]),
    ];
};

?>
<div class="newsletter-index">

    <?php if (Yii::$app->user->can('newsletter_manage')) : ?>

    <div class="pull-right buttons-container">
        <div class="btn-group">
            <?= Html::a(__('Create newsletter'), ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'subject',
                'link' => $detailsLink,
            ],
            'created_at:date',
            'updated_at:date',

            ['class' => 'app\widgets\grid\CounterColumn', 'label' => __('Mailing lists'), 'countField' => 'mailingListsCount'],
            ['class' => 'app\widgets\grid\CounterColumn', 'label' => __('Logs'), 'countField' => 'logsCount'],

            [
                'class' => 'app\widgets\grid\ActionColumn',
                'size' => 'xs',
                'items' => [
                    $detailsLink,
                    function($model) {
                        if (Yii::$app->user->can('newsletter_manage')) {
                            return [
                                'label' => __('Delete'),
                                'href' => Url::to(['newsletter/delete', 'id' => $model->id, '_return_url' => Url::to()]),
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
