<?php

use common\models\Setting;

$this->title = __('FAQ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-faq">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= Setting::get('faqpage_description') ?>

</div>
