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

            $is_profile = $controller_id == 'user' && $action_id == 'update' && $user->identity->id == $action_params['id'];
            
            /**
             * Left nav
             */

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

            /**
             * Right nav
             */

            // Tools
            $menu_items[] = [
                'label' => '<i class="glyphicon glyphicon-wrench"></i> ',
                'visible' => $user->can('user_manage')
                    || $user->can('print_template_manage')
                    || $user->can('country_manage')
                    || $user->can('state_manage'),
                'active' => in_array($controller_id, ['template']),
                'items' => [
                    [
                        'label' => Yii::t('app', 'Printing templates'),
                        'url' => ['/printtemplate/index'],
                        'visible' => $user->can('print_template_manage'),
                        'active' => $controller_id == 'print_template',
                    ],
                ],
            ];

            // Administration
            $menu_items[] = [
                'label' => '<i class="glyphicon glyphicon-cog"></i> ',
                'visible' => $user->can('user_manage')
                    || $user->can('country_manage')
                    || $user->can('state_manage'),
                'active' => in_array($controller_id, ['user', 'country', 'state']) && !$is_profile,
                'items' => [
                    [
                        'label' => Yii::t('app', 'Users'),
                        'url' => ['/user/index'],
                        'visible' => $user->can('user_manage'),
                        'active' => $controller_id == 'user' && !$is_profile,
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
            
            // Account
            $help_menu = [
                'items' => [
                    'contact' => [
                        'label' => Yii::t('app', 'Contact'),
                        'url' => ['/site/contact']
                    ],
                    'about' => [
                        'label' => Yii::t('app', 'About'),
                        'url' => ['/site/about']
                    ],
                ],
                'active' => $controller_id == 'site' && in_array($action_id, ['contact', 'about']),
            ];

            if (Yii::$app->user->isGuest) {
            
                $menu_items[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
                $menu_items[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];

                $menu_items[] = [
                    'label' => Yii::t('app', 'Help'),
                    'active' => $help_menu['active'],
                    'items' => $help_menu['items']
                ];
            
            } else {

                $name = trim($user->identity->fullname);
                if (empty($name)) {
                    $name = $user->identity->username;
                }
                $menu_items[] = [
                    'label' => '<i class="glyphicon glyphicon-user"></i>',
                    'active' => $is_profile || $help_menu['active'],
                    'items' => [
                        Html::tag('li', Html::a(__('Signed in as <br><b>{name}</b>', ['name' => $name])), ['class'=>'disabled']),
                        '<li class="divider"></li>',
                        [
                            'label' => Yii::t('app', 'Profile'),
                            'url' => ['/user/update', 'id' => $user->identity->id],
                            'active' => $is_profile,
                        ],
                        [
                            'label' => Yii::t('app', 'Logout'),
                            'url' => ['/site/logout'],
                            'linkOptions' => ['data-method' => 'post']
                        ],
                        '<li class="divider"></li>',
                        $help_menu['items']['contact'],
                        $help_menu['items']['about'],
                    ]
                ];

            }

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'encodeLabels' => false,
                'items' => $menu_items,
            ]);

            /**
             * Search nav
             */
            if ($user->can('partner_manage')) {
                echo '<form class="navbar-form navbar-left" role="search" method="get" action="' . Url::to(['partner/index']) . '">';
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
