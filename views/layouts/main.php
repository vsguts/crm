<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Language;
use app\widgets\Alert;
use app\widgets\LanguageSelector;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$this->registerJs(AppAsset::customJs());
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->params['brandName'],
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);

            $user = Yii::$app->user;
            $controller_id = Yii::$app->controller->id;
            $action_id = Yii::$app->controller->action->id;
            $action_params = Yii::$app->controller->actionParams;
            
            // Left nav
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' => [
                    [
                        'label' => Yii::t('app', 'Partners'),
                        'url' => ['/partner/index'],
                        'visible' => $user->can('partner_manage'),
                        'active' => $controller_id == 'partner',
                    ],
                    [
                        'label' => Yii::t('app', 'Visits'),
                        'url' => ['/visit/index'],
                        'visible' => $user->can('visit_manage'),
                        'active' => $controller_id == 'visit',
                    ],
                    [
                        'label' => Yii::t('app', 'Donates'),
                        'url' => ['/donate/index'],
                        'visible' => $user->can('donate_manage'),
                        'active' => $controller_id == 'donate',
                    ],
                    [
                        'label' => Yii::t('app', 'Tasks'),
                        'url' => ['/task/index'],
                        'visible' => $user->can('task_manage'),
                        'active' => $controller_id == 'task',
                    ],
                ],
            ]);

            // Right nav
            $is_profile = false;
            $menu_items = [];
            if (Yii::$app->user->isGuest) {
                $menu_items[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
                $menu_items[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
            } else {
                $name = trim($user->identity->fullname);
                if (empty($name)) {
                    $name = $user->identity->username;
                }
                $is_profile = $controller_id == 'user' && $action_id == 'update' && $user->identity->id == $action_params['id'];
                $menu_items[] = [
                    'label' => $name,
                    'active' => $is_profile,
                    'items' => [
                        [
                            'label' => Yii::t('app', 'Profile'),
                            'url' => ['/user/update', 'id' => $user->identity->id],
                            'active' => $is_profile,
                        ],
                        '<li class="divider"></li>',
                        [
                            'label' => Yii::t('app', 'Logout'),
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']
                        ],
                    ]
                ];
            }
            $menu_items[] = [
                'label' => Yii::t('app', 'Settings'),
                'visible' => $user->can('user_manage')
                    || $user->can('template_manage')
                    || $user->can('country_manage')
                    || $user->can('state_manage'),
                'active' => in_array($controller_id, ['user', 'template', 'country', 'state']) && !$is_profile,
                'items' => [
                    [
                        'label' => Yii::t('app', 'Users'),
                        'url' => ['/user/index'],
                        'visible' => $user->can('user_manage'),
                        'active' => $controller_id == 'user' && !$is_profile,
                    ],
                    [
                        'label' => Yii::t('app', 'Templates'),
                        'url' => ['/template/index'],
                        'visible' => $user->can('template_manage'),
                        'active' => $controller_id == 'template',
                    ],
                    '<li class="divider"></li>',
                    [
                        'label' => Yii::t('app', 'Countries'),
                        'url' => ['/country/index'],
                        'visible' => $user->can('country_manage'),
                        'active' => $controller_id == 'country',
                    ],
                    [
                        'label' => Yii::t('app', 'States'),
                        'url' => ['/state/index'],
                        'visible' => $user->can('state_manage'),
                        'active' => $controller_id == 'state',
                    ],
                ]
            ];
            $menu_items[] = [
                'label' => Yii::t('app', 'Help'),
                'items' => [
                    [
                        'label' => Yii::t('app', 'Contact'),
                        'url' => ['/site/contact']
                    ],
                    [
                        'label' => Yii::t('app', 'About'),
                        'url' => ['/site/about']
                    ],
                ]
            ];

            // Languages
            $languages = Language::find()->orderBy(['name' => SORT_ASC])->all();
            $select_language = false;
            $lang_items = [];
            foreach ($languages as $language) {
                if ($language->code == Yii::$app->language) {
                    $select_language = $language;
                    // break;
                }
                $lang_items[] = [
                    'label' => $language->name,
                    'url' => ['language/select', 'id' => $language->id, 'current_url' => Url::to()],
                    'active' => $language == $select_language,
                ];
            }
            $menu_items[] = ['label' => $select_language->short_name, 'items' => $lang_items];
            
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menu_items,
            ]);

            if ($user->can('partner_manage')) {
                // Search nav
                echo '<form class="navbar-form navbar-left" role="search" method="get" action="' . Url::to(['/']) . '">';
                echo '    <input type="hidden" name="r" value="partner/index" />';
                echo '    <div class="form-group">';
                echo '        <input type="text" name="q" class="form-control" placeholder="' . __('Search') . '" value="' . Yii::$app->request->get('q') . '">';
                echo '    </div>';
                echo '</form>';
            }

            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; <?= Yii::$app->params['companyName'] ?> <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
