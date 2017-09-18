<?php

namespace common\models\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use common\models\Image;

class ImageUploaderBehavior extends Behavior
{
    const UPDATE_IMAGES_FIELD = 'images';

    public $imagesUpload = []; // upload

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'attachImages',
            ActiveRecord::EVENT_AFTER_UPDATE => 'updateImages',
        ];
    }

    public function attributeLabels()
    {
        return [
            'imagesUpload' => __('Images upload')
        ];
    }

    public function attachImages($event)
    {
        $model = $event->sender;
        
        $images = UploadedFile::getInstances($model, 'imagesUpload');
        foreach ($images as $image) {
            $model->attachImage($image);
        }
    }

    public function updateImages($event)
    {
        $post = \Yii::$app->request->post();
        $model = $this->owner;
        $form_name = $model->formName();
        if (isset($post[$form_name][static::UPDATE_IMAGES_FIELD])) {
            $images = $post[$form_name][static::UPDATE_IMAGES_FIELD];

            if (!empty($images['default'])) {
                $image = Image::findOne($images['default']);
                $image->default = true;
                $image->save();
            }

            if (!empty($images['delete'])) {
                foreach ($images['delete'] as $id => $_v) {
                    $image = Image::findOne($id);
                    $model->removeImage($image);
                }
            }
        }

        $this->attachImages($event);
    }

}
