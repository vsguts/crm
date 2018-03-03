<?php

use yii\helpers\Html;
use app\helpers\Url;

/** @var \app\models\User $model */
/** @var \app\widgets\form\ActiveForm $form */

foreach ($roles as $name => $role) {
    $roles[$name] .= ' ' . Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-link']), null, [
            'href' => Url::to(['user-role/index', 'id' => $name, '#' => 'user-role_' . $name]),
            'target' => '_blank',
        ]);
}

echo $form->field($model, 'roles')->checkboxList($roles, [
    'id' => $form_id . '-roles',
    'unselect' => null,
]);
