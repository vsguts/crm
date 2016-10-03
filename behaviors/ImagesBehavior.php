<?php

namespace app\behaviors;

use yii\base\Behavior;
use yii\helpers\FileHelper;
use yii\db\ActiveRecord;
use app\models\Image;
use app\models\ImagePlaceholder;

class ImagesBehavior extends Behavior
{
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_DELETE => 'removeImages',
        ];
    }

    public function getImage()
    {
        $image = Image::find()
            ->where([
                'table' => $this->owner->tableName(),
                'object_id' => $this->owner->id,
                'default' => 1,
            ])
            ->one();

        if (!$image) {
            $image = new ImagePlaceholder;
        }

        return $image;
    }

    public function getImages()
    {
        return Image::find()
            ->where([
                'table' => $this->owner->formName(),
                'object_id' => $this->owner->id,
            ])
            ->orderBy(['default' => SORT_DESC, 'id' => SORT_ASC])
            ->all();
    }

    public function attachImage($attach, $default = false)
    {
        $image = new Image;
        $image->attach = $attach;
        $image->related_model = $this->owner;
        $image->table = $this->owner->formName();
        $image->object_id = $this->owner->id;
        $image->save();
        $image->default = $default;
        return $image;
    }

    public function removeImages($event = false)
    {
        if ($event) {
            $model = $event->sender;
        } else {
            $model = $this->owner;
        }

        $dirs = [];
        foreach ($model->getImages() as $image) {
            if (!$dirs) {
                $dirs[] = $image->getPath(false, false, true);
                $dirs[] = $image->getPath(true, false, true);
            }
            $image->delete();
        }
        foreach ($dirs as $dir) {
            FileHelper::removeDirectory($dir);
        }
    }

    public function removeImage(Image $image)
    {
        if ($image->table == $this->owner->formName()) {
            $image->delete();
        }
    }

}
