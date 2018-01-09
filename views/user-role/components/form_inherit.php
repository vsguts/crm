<?php

use app\helpers\ViewHelper;
use app\models\AuthItem;

/** @var AuthItem $model */

$roles = [];

$inheritedRoles = $model->getRolesInheritedRecursive();
$items = AuthItem::find()
    ->select(['name', 'description', 'status'])
    ->roles()
    ->nonSystem()
    ->sorted()
    ->andWhere(['not', ['name' => $model->name]])
    ->asArray()
    ->all();

foreach ($items as $item) {
    $description = $item['description'];
    if (in_array($item['name'], $inheritedRoles)) {
        $description = ViewHelper::wrapInheritedText($description);
    }
    $roles[$item['name']] = [
        'label' => $description,
        'status' => $item['status'],
    ];
}
foreach ($roles as $name => $role) {
    $roles[$name]['label'] .= ' ' . Html::a(
            Html::tag('span', '', ['class' => 'glyphicon glyphicon-link']),
            Url::to(['user-role/index', 'id' => $name, '#' => 'user-role_' . $name]),
            ['target' => '_blank']
        );
}

echo $form
    ->field($model, 'roles')
    ->checkboxList($roles, [
        'item' => function($index, $label, $name, $checked, $value) use($model) {
            $status_class = '';
            if (!empty($label['status'])) {
                $status_class = 'status-' . $label['status'];
            }
            return Html::tag(
                'div',
                Html::checkbox($name, $checked, ['label' => $label['label'], 'value' => $value]),
                ['class' => ['checkbox', $status_class]]
            );
        },
    ]);
