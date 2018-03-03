<?php

use app\widgets\form\SearchForm;

?>

<div class="state-search">

    <?php $form = SearchForm::begin(['action' => ['report']]); ?>

    <?= Html::activeHiddenInput($model, 'report') ?>

    <?= $this->render('/common/search/period', [
        'model' => $model,
        'form' => $form,
    ]) ?>

    <?= $this->blocks['searchContent'] ?? null ?>

    <?php SearchForm::end(); ?>

</div>
