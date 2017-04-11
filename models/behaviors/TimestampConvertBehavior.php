<?php

namespace app\models\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\base\Model;

class TimestampConvertBehavior extends Behavior
{
    public $fields = ['timestamp'];

    public $decodeFields = [];

    public function events()
    {
        return [
            Model::EVENT_AFTER_VALIDATE => 'encodeTimestamp',
            ActiveRecord::EVENT_AFTER_FIND => 'decodeTimestamp',
            ActiveRecord::EVENT_AFTER_INSERT => 'decodeTimestamp',
            ActiveRecord::EVENT_AFTER_UPDATE => 'decodeTimestamp',
        ];
    }

    public function encodeTimestamp($event)
    {
        $model = $this->owner;
        $formatter = Yii::$app->formatter;
        foreach ((array)$this->fields as $field) {
            if (isset($model->$field) && $model->$field) {
                $model->$field = $formatter->asTimestamp($model->$field);
            }
        }
    }

    public function decodeTimestamp($event)
    {
        $model = $this->owner;
        $formatter = Yii::$app->formatter;
        foreach ((array)$this->decodeFields as $key => $field) {
            $format = 'date';
            if (!is_numeric($key)) {
                $format = $field;
                $field = $key;
            }
            if (isset($model->$field) && $model->$field) {
                $method = 'as' . ucfirst($format);
                $model->$field = $formatter->$method($model->$field);
            }
        }
    }

}
