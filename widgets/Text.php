<?php

namespace app\widgets;

use Yii;
use yii\widgets\InputWidget;

class Text extends InputWidget
{
    public $formatter;

    public function init()
    {
        parent::init();
        
        $value = $this->model->{$this->attribute};
        
        if ($this->formatter) {
            $method = 'as' . ucfirst($this->formatter);
            $value = Yii::$app->formatter->$method($value);
        }

        echo '<p class="form-text-value">' . $value . '</p>';
    }
}
