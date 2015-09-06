<?php

namespace app\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;

class TimestampConvertBehavior extends AttributeBehavior
{
    public $field = 'timestamp';

    public function init()
    {
        parent::init();
        
        if (empty($this->attributes)) {
            $this->attributes = [
                ActiveRecord::EVENT_AFTER_FIND => $this->field,
                ActiveRecord::EVENT_BEFORE_INSERT => $this->field,
                ActiveRecord::EVENT_AFTER_INSERT => $this->field,
                ActiveRecord::EVENT_BEFORE_UPDATE => $this->field,
                ActiveRecord::EVENT_AFTER_UPDATE => $this->field,
            ];
        }
    }

    protected function getValue($event)
    {
        $value = $this->owner->{$this->field};
        $formatter = Yii::$app->formatter;
        if (strpos($event->name, 'before') === 0) { // encode
            return $formatter->asTimestamp($value);
        } else { // decode
            return $formatter->asDate($value);
        }
    }

}
