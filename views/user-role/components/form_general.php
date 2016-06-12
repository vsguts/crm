<?php

echo $form->field($model, 'description')->textInput();

if (!$model->isNewRecord) {
    echo $form->field($model, 'name')->widget('app\widgets\Text');
}
