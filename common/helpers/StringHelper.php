<?php

namespace common\helpers;

class StringHelper extends \yii\helpers\StringHelper
{

    public static function stringNotEmpty($str)
    {
        return strlen((trim($str))) > 0;
    }

}
