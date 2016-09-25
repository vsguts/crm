<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
use app\widgets\ImagesGallery;

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

    <div class="app-ajax-overlay"></div>
    <div class="app-ajax-spinner"></div>

    <div class="wrap">
        <?= $this->render('components/navbar') ?>
        <div class="container-fluid">
        <?php
            $params = [
                'breadcrumbs' => $this->render('components/breadcrumbs'),
                'alerts' => $this->render('components/alerts'),
                'content' => $content,
            ];
            if (!empty($this->blocks['sidebox'])) {
                echo $this->render('wrappers/sidebox', $params);
            } else {
                echo $this->render('wrappers/simple', $params);
            }

            ImagesGallery::renderTemplate();
        ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container-fluid">
            <p class="pull-left">&copy; <?= Yii::$app->params['companyName'] ?> <?= date('Y') ?></p>
            <?php if (Yii::$app->params['poweredBy']) : ?>
            <p class="pull-right"><?= __('Powered by') . ' ' . Yii::$app->params['poweredBy'] ?></p>
            <?php endif; ?>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
