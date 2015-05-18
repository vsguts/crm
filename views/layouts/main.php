<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;
use app\widgets\ImagesGallery;

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

    <div class="m-ajax-overlay"></div>
    <div class="m-ajax-spinner"></div>

    <div class="wrap">
        <?= $this->render('components/navbar') ?>
        <div class="container">
        <?php
            $params = [
                'breadcrumbs' => $this->render('components/breadcrumbs'),
                'alerts' => $this->render('components/alerts'),
                'content' => $content,
            ];
            if (!empty($this->blocks['sidebox'])) {
                echo $this->render('layouts/sidebox', $params);
            } else {
                echo $this->render('layouts/simple', $params);
            }

            ImagesGallery::renderTemplate();
        ?>
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
