<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = __('About');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Made by: Vladimir Guts</p>
    <p>Make for: <a href="http://www.wycliffe.ru/" target="_blank">wycliffe</a></p>
    <p>Powered by: Yii Framework</p>

</div>
