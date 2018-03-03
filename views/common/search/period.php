<?php

use app\widgets\form\DatePickerRange;
use app\widgets\PeriodLinks;

?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'timestamp')->widget(DatePickerRange::class) ?>
    </div>
    <div class="col-md-6">
        <?= $this->blocks['searchAddField'] ?? null ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="pull-right">
            <?= PeriodLinks::widget(['model' => $model]) ?>
        </div>
    </div>
</div>

