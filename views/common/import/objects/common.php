<?php

echo Html::activeHiddenInput($model, 'object_id');

echo $form->field($model, 'formatter')->dropDownList($formatters, [
    'class' => 'app-dtoggle app-dtoggle-formatter form-control'
]);

$simpleFormatFields = [
    $form->field($model, 'delimiter')->dropDownList($model->availableDelimiters)
];

echo Html::tag('div', implode(' ', $simpleFormatFields), [
    'class' => ['app-dtoggle-formatter-csv h', 'app-dtoggle-formatter-txt h']
]);
