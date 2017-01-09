<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = __('About');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Yii::$app->params['aboutpage_description'] ?>

</div>
