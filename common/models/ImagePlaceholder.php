<?php

namespace common\models;

class ImagePlaceholder extends Image
{

    public function init()
    {
        parent::init();
        $this->table = false;
        $this->object_id = false;
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
