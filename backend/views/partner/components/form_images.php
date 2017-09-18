<?php

use yii\helpers\Url;

/** @var \common\models\Partner $model */
/** @var \common\widgets\form\ActiveForm $form */

$object_id = 'partner_' . $model->id . '_images'; 

if ($model->images) {
    $field = $form->field($model, 'images', [
        'template' => '{input}',
        'enableLabel' => false,
    ]);

    echo Html::beginTag('div', ['id' => $object_id]);

    if (!empty($_REQUEST['edit_images'])) {
        echo $field->widget('common\widgets\form\ImagesUpdate', [
            'viewLink' => Url::to(['update', 'id' => $model->id]),
            'objectId' => $object_id,
        ]);
    } else {
        echo $field->widget('common\widgets\ImagesGallery', [
            'editLink' => Url::to(['update', 'id' => $model->id, 'edit_images' => 1]),
            'objectId' => $object_id,
        ]);
    }

    echo Html::endTag('div');
}

echo $form->field($model, 'imagesUpload[]')->fileInput([
    'multiple' => true,
    'options' => [
        'id' => $object_id . '_imagesUpload',
    ],
]);
