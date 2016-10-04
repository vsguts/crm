<?php

namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\Json;

class ListBehavior extends Behavior
{
    public $fields = [];

    public $delimiter = ',';

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'decode',
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'encode',
            ActiveRecord::EVENT_AFTER_INSERT => 'decode',
            ActiveRecord::EVENT_AFTER_UPDATE => 'decode',
        ];
    }

    public function encode($event)
    {
        $model = $this->owner;
        foreach ((array)$this->fields as $field) {
            if (isset($model->$field) && is_array($model->$field)) {
                $model->$field = implode($this->delimiter, $model->$field);
            }
        }
    }

    public function decode($event)
    {
        $model = $this->owner;
        foreach ((array)$this->fields as $field) {
            if (isset($model->$field) && !is_array($model->$field)) {
                $model->$field = explode($this->delimiter, $model->$field);
            }
        }
    }

}
