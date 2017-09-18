<?php

use common\widgets\form\ButtonsContatiner;
use common\widgets\Modal;

if ($model->isNewRecord) {
    $obj_id = 'user_create';
    $header = __('Create user');
} else {
    $obj_id = 'user_' . $model->id;
    $header = __('User: {user}', [
        'user' => $model->name,
    ]);
}

$form_id = $obj_id . '_form';

Modal::begin([
    'size' => Modal::SIZE_LARGE,
    'header' => $header,
    'id' => $obj_id,
    'footer' => ButtonsContatiner::widget([
        'model' => $model,
        'saveLink' => $model->canManage(),
        'form' => $form_id,
    ]),
]);

echo $this->render('components/form', [
    'model' => $model,
    'form_id' => $form_id,
    'roles' => isset($roles) ? $roles : null,
]);

Modal::end();
