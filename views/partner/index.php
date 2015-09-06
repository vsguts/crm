<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActionsDropdown;

$this->title = Yii::t('app', 'Partners');
$this->params['breadcrumbs'][] = $this->title;
// $this->params['sidebox_size'] = 3;
?>

<div class="partner-index">

    <div class="pull-right buttons-container">
        <div class="btn-group">
            <?= Html::a(Yii::t('app', 'Create partner'), ['create'], ['class' => 'btn btn-success']) ?>
        </div>
        
        <?php

        $items = [
            [
                'label' => __('Delete'),
                'url' => Url::to(['delete']),
                'linkOptions' => [
                    'data-c-process-items' => 'ids',
                    'data-confirm' => __('Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                ]
            ],
            [
                'label' => __('Export'), 'url' => Url::to(['/export/index', 'object' => 'partners']),
                'linkOptions' => ['data-c-process-items' => 'ids']
            ],
            [
                'label' => __('Show on map'), 'url' => Url::to(['map']),
                'linkOptions' => ['data-c-process-items' => 'ids']
            ],
        ];
        if (Yii::$app->user->can('newsletter_manage')) {
            $items[] = [
                'label' => __('Add to mailing list'),
                'url' => Url::to(['/mailing-list/append-partners']),
                'linkOptions' => [
                    'data-c-process-items' => 'partner_ids',
                    'class' => 'c-modal c-modal-force',
                    'data-target-id' => 'append_partners',
                ]
            ];
        }

        echo ActionsDropdown::widget([
            'layout' => 'info',
            'items' => $items,
        ]);

        ?>
        
    </div>
    
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('components/search', ['model' => $searchModel, 'tags' => $tags]) ?>
    
    <?= $this->render('components/grid', ['dataProvider' => $dataProvider]) ?>

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
