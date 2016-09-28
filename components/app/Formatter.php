<?php

namespace app\components\app;

use Yii;

class Formatter extends \yii\i18n\Formatter
{
    public function asRoundInteger($value)
    {
        return $this->asInteger(round($value));
    }

    public function asMoney($value, $decimals = 2)
    {
        return $this->asDecimal($value, $decimals);
    }

    public function asSimpleMoney($value, $decimals = 2)
    {
        return round($value, $decimals);
    }

    public function asDateFiltered($value, $format = null)
    {
        return $value ? parent::asDate($value, $format) : null;
    }

    public function asDatetimeFiltered($value, $format = null)
    {
        return $value ? parent::asDatetime($value, $format) : null;
    }

}
