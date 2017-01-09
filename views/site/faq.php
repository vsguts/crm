<?php

$this->title = __('FAQ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-faq">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Yii::$app->params['faqpage_description'] ?>

</div>
