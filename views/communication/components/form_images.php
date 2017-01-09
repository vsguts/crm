<?php

use yii\helpers\Url;

$object_id = 'communication_' . $model->id . '_images';

if ($model->images) {
    $field = $form->field($model, 'images', [
        'template' => '{input}',
        'enableLabel' => false,
    ]);

    echo '<div id="' . $object_id . '">';

    if (!empty($_REQUEST['edit_images'])) {
        echo $field->widget('app\widgets\ImagesUpdate', [
            'viewLink' => Url::to(['/communication/update', 'id' => $model->id]),
            'objectId' => $object_id,
        ]);
    } else {
        echo $field->widget('app\widgets\ImagesGallery', [
            'editLink' => Url::to(['/communication/update', 'id' => $model->id, 'edit_images' => 1]),
            'objectId' => $object_id,
        ]);
    }

    echo '</div>';
}

echo $form->field($model, 'imagesUpload[]')->widget('app\widgets\FileInput', [
    'options' => [
        'id' => $object_id . '_file_input',
    ],
]);

