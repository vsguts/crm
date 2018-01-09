<?php

namespace app\helpers;

use Yii;
use yii\helpers\Html;

class ViewHelper
{
    public static function getTextClass($value)
    {
        if ($value > 0) {
            return 'text-success';
        } elseif ($value < 0) {
            return 'text-danger';
        }
    }

    public static function wrapInheritedText($text)
    {
        return $text . ' ' . Html::tag('span', __('inherited'), ['class' => 'label label-default']);
    }

    /**
     * [
     *     '<currency_id>' => '<amount>',
     * ]
     * @param $data
     * @return string
     */
    public static function getCurrencyValues($data)
    {
        $text = '';
        if (!empty($data)) {
            $result = [];
            foreach ($data as $currencyId => $value) {
                if (floatval($value)) {
                    $result[] = Yii::$app->formatter->asMoneyWithSymbol($value, $currencyId);
                }
            }
            $text = implode('<br />', $result);
        }
        return $text;
    }

}
