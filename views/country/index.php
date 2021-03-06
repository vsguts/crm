<?php

use app\models\Country;
use app\models\State;
use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\grid\GridView;
use app\widgets\ActionsDropdown;

/** @var \yii\data\ActiveDataProvider $dataProvider */
/** @var \app\models\search\CountrySearch $searchModel */

$this->title = __('Countries');
$this->params['breadcrumbs'][] = $this->title;

$detailsLink = function($model) {
    return [
        'label' => __('Edit'),
        'class' => 'app-modal',
        'href' => Url::to(['/country/update', 'id' => $model->id, '_return_url' => Url::to()]),
        'data-target-id' => 'country_' . $model->id,
    ];
};

$stateCounts = State::find()
    ->andWhere(['country_id' => $dataProvider->getKeys()])
    ->countByColumn('country_id');

?>
<div class="country-index">

    <?php if (Yii::$app->user->can('country_manage')) : ?>

    <div class="pull-right buttons-container">
        <div class="btn-group">
            <?= Html::a(__('Create country'), ['update', '_return_url' => Url::to()], [
                'class' => 'btn btn-success app-modal',
                'data-target-id' => 'country_create',
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
            'code',
            [
                'class' => 'app\widgets\grid\CounterColumn',
                'label' => __('States'),
                'count' => function (Country $model) use ($stateCounts) {
                    return $stateCounts[$model->id] ?? 0;
                },
                'link' => function (Country $model) {
                    return Url::to(['state/index', 'country_id' => $model->id]);
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
                        if (Yii::$app->user->can('country_manage')) {
                            return [
                                'label' => __('Delete'),
                                'href' => Url::to(['country/delete', 'id' => $model->id, '_return_url' => Url::to()]),
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
