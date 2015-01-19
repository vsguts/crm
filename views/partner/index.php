<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActionsDropdown;
use app\widgets\grid\GridView;

$this->title = Yii::t('app', 'Partners');
$this->params['breadcrumbs'][] = $this->title;
// $this->params['sidebox_size'] = 3;
?>

<div class="partner-index">

    <div class="pull-right">
        <div class="btn-group">
            <?= Html::a(Yii::t('app', 'Create partner'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        <?= ActionsDropdown::widget([
            'layout' => 'info',
            'items' => [
                ['label' => __('Delete selected'), 'url' => Url::to(['delete']), 'linkOptions' => [
                    'data-c-process-items' => 'ids',
                    'data-confirm' => __('Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                ]],
                ['label' => __('Export selected'), 'url' => Url::to(['/export/index', 'object' => 'partners']), 'linkOptions' => [
                    'data-c-process-items' => 'ids',
                ]],
                // '<li role="presentation" class="divider"></li>',
                ['label' => __('Show on map'), 'url' => Url::to(['map']), 'linkOptions' => [
                    'data-c-process-items' => 'ids',
                ]],
            ],
        ]) ?>
    </div>
    
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/search', ['model' => $searchModel, 'tags' => $tags]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            
            ['attribute' => 'id', 'label' => '#'],

            ['class' => 'app\widgets\grid\ImageColumn'],
            
            'name',
            'email:email',
            'city',
            ['attribute' => 'typeName', 'label' => Yii::t('app', 'Type')],
            ['attribute' => 'statusName', 'label' => Yii::t('app', 'Status')],
            'created_at:date',
            // 'country_id',
            // 'state_id',
            // 'state',
            // 'address',
            // 'church_id',
            // 'volunteer',
            // 'candidate',
            // 'notes:ntext',
            // 'updated_at',

            // ['class' => 'app\widgets\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<?php $this->beginBlock('sidebox'); ?>

    <?php foreach ($tags as $list_name => $tag_list) : ?>
        <?= Html::tag('h4', $list_name) ?>
        <ul class="nav nav-pills nav-stacked">
            <?php foreach ($tag_list as $tag) : ?>
                <?php $class = (isset($_REQUEST['PartnerSearch']['tag_id']) && $_REQUEST['PartnerSearch']['tag_id'] == $tag->id) ? 'active' : '' ?>
                <li role="presentation" class="<?= $class ?>">
                    <a href="<?= Url::to(['partner/index', 'PartnerSearch[tag_id]' => $tag->id]) ?>">
                        <span class="badge pull-right"><?= $tag->partnersCount ?></span>
                        <?= $tag->name ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>

    <br/>
    <ul class="nav nav-pills nav-stacked">
        <li role="presentation" class="pull-right">
            <a href="<?= Url::to(['partner/index']) ?>"><?= __('Reset') ?></a>
        </li>
    </ul>
    
<?php $this->endBlock(); ?>
