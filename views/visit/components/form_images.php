<?php

use yii\helpers\Url;

if ($model->images) {
    $field = $form->field($model, 'images', [
        'template' => '{input}',
        'enableLabel' => false,
    ]);

    $object_id = 'visit_' . $model->id . '_images'; 
    echo '<div id="' . $object_id . '">';

    if (!empty($_REQUEST['edit_images'])) {
        echo $field->widget('app\widgets\ImagesUpdate', [
            'viewLink' => Url::to(['/visit/update', 'id' => $model->id]),
            'objectId' => $object_id,
        ]);
    } else {
        echo $field->widget('app\widgets\ImagesGallery', [
            'editLink' => Url::to(['/visit/update', 'id' => $model->id, 'edit_images' => 1]),
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

