<?php


foreach ($model->getAllPermissions() as $header => $sections) {
    echo Html::tag('h4', $header);
    foreach ($sections as $section => $permissions) {
        // pd($form->field($model, 'permissions'));
        echo $form->field($model, 'permissions', [
            'horizontalCssClasses' => [
                'label' => 'col-sm-3',
                'wrapper' => 'col-sm-9',
            ]
        ])->checkboxList($permissions, ['unselect' => null])->label($section);
    }
}
