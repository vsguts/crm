<?php

namespace app\models\export\formatter;

use Yii;
use yii\base\Object;

abstract class AFormatter extends Object
{
    public $position = 10;

    public $owner;

    public $columns = [];
    public $data = [];

    abstract public function export();

}
