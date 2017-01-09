<?php

namespace app\models\export\formatter;

use yii\base\Object;

abstract class AbstractFormatter extends Object
{
    public $position = 10;

    public $owner;

    public $columns = [];

    public $data = [];

    abstract public function export($file_path = null);

}
