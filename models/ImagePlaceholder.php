<?php

namespace app\models;

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

}
