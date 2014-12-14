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

            $controller_id = Yii::$app->controller->id;
            
            // Left nav
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' => [
                    [
                        'label' => Yii::t('app', 'Partners'),
                        'url' => ['/partner/index'],
                        'active' => $controller_id == 'partner',
                    ],
                    [
                        'label' => Yii::t('app', 'Visits'),
                        'url' => ['/visit/index'],
                        'active' => $controller_id == 'visit',
                    ],
                    [
                        'label' => Yii::t('app', 'Donates'),
                        'url' => ['/donate/index'],
                        'active' => $controller_id == 'donate',
                    ],
                    [
                        'label' => Yii::t('app', 'Tasks'),
                        'url' => ['/task/index'],
                        'active' => $controller_id == 'task',
                    ],
                ],
            ]);

            // Right nav
            $menu_items = [];
            if (Yii::$app->user->isGuest) {
                $menu_items[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
                $menu_items[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
            } else {
                $user = Yii::$app->user->identity;
                $name = trim($user->fullname);
                if (empty($name)) {
                    $name = $user->username;
                }
                $menu_items[] = [
                    'label' => $name,
                    'items' => [
                        ['label' => Yii::t('app', 'Profile'), 'url' => ['/user/update', 'id' => $user->id]],
                        '<li class="divider"></li>',
                        ['label' => Yii::t('app', 'Logout'), 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
                    ]
                ];
            }
            $menu_items[] = ['label' => Yii::t('app', 'Settings'), 'items' => [
                ['label' => Yii::t('app', 'Users'), 'url' => ['/user/index']],
                ['label' => Yii::t('app', 'Templates'), 'url' => ['/template/index']],
                '<li class="divider"></li>',
                ['label' => Yii::t('app', 'Countries'), 'url' => ['/country/index']],
                ['label' => Yii::t('app', 'States'), 'url' => ['/state/index']],
            ]];
            $menu_items[] = ['label' => Yii::t('app', 'Help'), 'items' => [
                ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
                ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
            ]];

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

            // Search nav
            echo '<form class="navbar-form navbar-left" role="search" method="get" action="' . Url::to(['/']) . '">';
            echo '    <input type="hidden" name="r" value="partner/index" />';
            echo '    <div class="form-group">';
            echo '        <input type="text" name="q" class="form-control" placeholder="' . __('Search') . '" value="' . Yii::$app->request->get('q') . '">';
            echo '    </div>';
            echo '</form>';

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
