<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridView;
use app\widgets\ActionsDropdown;

$this->title = __('States');
$this->params['breadcrumbs'][] = $this->title;

$detailsLink = function($model) {
    return [
        'label' => __('Edit'),
        'class' => 'app-modal',
        'href' => Url::to(['/state/update', 'id' => $model->id, '_return_url' => Url::to()]),
        'data-target-id' => 'state_' . $model->id,
    ];
};

?>
<div class="state-index">

    <?php if (Yii::$app->user->can('state_manage')) : ?>

    <div class="pull-right buttons-container">
        <div class="btn-group">
            <?= Html::a(__('Create state'), ['update', '_return_url' => Url::to()], [
                'class' => 'btn btn-success app-modal',
                'data-target-id' => 'state_create',
            ]) ?>
        </div>
        <?= ActionsDropdown::widget([
            'layout' => 'info',
            'items' => [
                ['label' => __('Delete'), 'url' => Url::to(['delete']), 'linkOptions' => [
                    'data-app-process-items' => 'ids',
                    'data-confirm' => __('Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                ]],
            ],
        ]) ?>
    </div>

    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('components/search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

            // ['attribute' => 'id', 'label' => '#'],
            [
                'attribute' => 'name',
                'link' => $detailsLink,
            ],
            [
                'attribute' => 'country.name',
                'label' => __('Country'),
                'link' => function($model) {
                    return [
                        'class' => 'app-modal',
                        'href' => Url::to(['/country/update', 'id' => $model->country_id, '_return_url' => Url::to()]),
                        'data-target-id' => 'country_' . $model->country_id,
                    ];
                },
            ],
            'code',

            [
                'class' => 'app\widgets\grid\ActionColumn',
                'size' => 'xs',
                'items' => [
                    $detailsLink,
                    function($model) {
                        if (Yii::$app->user->can('state_manage')) {
                            return [
                                'label' => __('Delete'),
                                'href' => Url::to(['state/delete', 'id' => $model->id, '_return_url' => Url::to()]),
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
