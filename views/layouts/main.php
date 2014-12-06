<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\widgets\Alert;

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

            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' => [
                    ['label' => Yii::t('app', 'Partners'), 'url' => ['/partner/index']],
                    ['label' => Yii::t('app', 'Donates'), 'url' => ['/donate/index']],
                    ['label' => Yii::t('app', 'Tasks'), 'url' => ['/task/index']],
                    ['label' => Yii::t('app', 'Visits'), 'url' => ['/visit/index']],
                ],
            ]);

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
                '<li class="divider"></li>',
                ['label' => 'Lookup', 'url' => ['/lookup/index']],
                '<li class="divider"></li>',
                ['label' => Yii::t('app', 'Tags'), 'url' => ['/tag/index']],
            ]];
            $menu_items[] = ['label' => Yii::t('app', 'Help'), 'items' => [
                ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
                ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
            ]];
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menu_items,
            ]);

            echo <<<EOF
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                    </div>
                </form>
EOF;

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
