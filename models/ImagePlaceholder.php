<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property string $model_name
 * @property integer $model_id
 * @property string $filename
 */
class ImagePlaceholder extends Image
{

    public function init()
    {
        parent::init();
        $this->model_name = false;
        $this->model_id = false;
        $this->filename = 'placeholder.jpg';
    }

    public function beforeSave($insert)
    {
        return false;
    }

    public function beforeDelete()
    {
        return false;
    }

    public function getPath($size = '', $alias = false, $only_dir = false)
    {
        $path = parent::getPath($size, $alias, $only_dir);

        if (!$size) {
            $path = str_replace('/store/', '/', $path); // FIXME
        }

        return $path;
    }

}
