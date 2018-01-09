<?php

use app\helpers\ViewHelper;
use app\models\AuthItem;

$processPermissions = function($permissions) use ($model) {
    foreach ($model->getPermissionsInheritedRecursive() as $name) {
        if (isset($permissions[$name])) {
            $permissions[$name] = ViewHelper::wrapInheritedText($permissions[$name]);
        }
    }
    return $permissions;
};

foreach (AuthItem::find()->getPermissionsGrouped() as $header => $sections) {
    echo Html::tag('h4', $header);
    foreach ($sections as $section => $permissions) {
        echo $form->field($model, 'permissions', [
            'horizontalCssClasses' => [
                'label' => 'col-sm-3',
                'wrapper' => 'col-sm-9',
            ]
        ])->checkboxList($processPermissions($permissions), ['unselect' => null])->label($section);
    }
}
