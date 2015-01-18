<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = \Yii::$app->params['applicationName'];
$user = Yii::$app->user;

?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= __('Welcome to CRM') ?></h1>

        <p class="lead"><?= __('Our system allows you to manage partners and relationships with them.') ?></p>

        <?php 
            if ($user->can('partner_manage')) {
                echo '<p><a class="btn btn-lg btn-success" href="' . Url::to(['partner/index']) . '"> ' . __('Partners') . '</a></p>';
            }
        ?>
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
