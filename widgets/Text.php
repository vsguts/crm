<?php

namespace app\widgets;

use Yii;
use yii\widgets\InputWidget;

/**
 * @deprecated
 * @use ->text
 */
class Text extends InputWidget
{
    public $formatter;

    public $value;

    public function init()
    {
        parent::init();

        $value = $this->value;

        if (is_null($value) && $this->attribute) {
            $value = $this->model->{$this->attribute};
        }

        $method = 'asRaw';
        if ($this->formatter) {
            $method = 'as' . ucfirst($this->formatter);
        }
        $value = Yii::$app->formatter->$method($value);

        echo '<p class="form-text-value">' . $value . '</p>';
    }
}
