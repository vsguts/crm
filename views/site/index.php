<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = \Yii::$app->params['applicationName'];
$user = Yii::$app->user;

?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= __('Welcome') ?></h1>

        <p class="lead">
            <?= Yii::$app->params['mainpage_description'] ?>
        </p>

    </div>

    <div class="body-content">

        <?php if (!empty($dashboard)) : ?>

            <h1 class="page-header"><?= __('Dashboard') ?></h1>

            <ul class="list-group">
            <?php
                foreach ($dashboard as $row) {
                    $span = Html::tag('span', $row['count'], ['class' => 'badge']);
                    $href = Html::a($row['name'], $row['link']);
                    echo Html::tag('li', $span . $href, ['class' => 'list-group-item']);
                }
            ?>
            </ul>

        <?php endif; ?>

    </div>

</div>
