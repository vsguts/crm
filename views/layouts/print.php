<?php
use app\assets\PrintAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

PrintAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
<div class="container">

<?= $content ?>

</div>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
