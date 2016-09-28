<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\widgets\ActionsDropdown;

$this->title = __('Partners');
$this->params['breadcrumbs'][] = $this->title;
// $this->params['sidebox_size'] = 3;
// $this->params['sidebox_side'] = 'right';
?>

<div class="partner-index">

    <div class="pull-right buttons-container">
        <?php if (Yii::$app->user->can('partner_manage')) : ?>
            <div class="btn-group">
                <?= Html::a(__('Create partner'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        <?php endif; ?>
        
        <?php

        $items = [
            [
                'label' => __('Export selected'),
                'url' => Url::to(['/export/export/', 'object' => 'partner']),
                'linkOptions' => [
                    'class' => 'app-modal app-modal-force',
                    'data-target-id' => 'export',
                    'data-app-process-items' => 'ids',
                ],
            ],
            [
                'label' => __('Export all'),
                'url' => Url::to(['/export/export/', 'object' => 'partner', 'attributes' => ['queryParams' => Yii::$app->request->queryParams]]),
                'linkOptions' => [
                    'class' => 'app-modal app-modal-force',
                    'data-target-id' => 'export',
                ],
            ],
        ];

        if (Yii::$app->user->can('newsletter_manage')) {
            $items[] = '<li role="presentation" class="divider"></li>';
            $items[] = [
                'label' => __('Add to mailing list'),
                'url' => Url::to(['/mailing-list/append-partners']),
                'linkOptions' => [
                    'data-app-process-items' => 'partner_ids',
                    'class' => 'app-modal app-modal-force',
                    'data-target-id' => 'append_partners',
                ]
            ];
        }

        if (Yii::$app->user->can('partner_manage')) {
            $items[] = '<li role="presentation" class="divider"></li>';
            $items[] = [
                'label' => __('Delete selected'),
                'url' => Url::to(['delete']),
                'linkOptions' => [
                    'data-app-process-items' => 'ids',
                    'data-confirm' => __('Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                ]
            ];
        }
        // $items[] = [
        //     'label' => __('Show on map'), 'url' => Url::to(['map']),
        //     'linkOptions' => ['data-app-process-items' => 'ids']
        // ];

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

    <div class="tags-sidebox">
    
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

    </div>
    
<?php $this->endBlock(); ?>
