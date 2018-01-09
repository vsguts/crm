<?php

namespace app\helpers;

use Yii;

class Url extends \yii\helpers\Url
{

    public static function to($url = '', $scheme = false, $returnUrl = false)
    {
        if ($returnUrl) {
            $return = static::returnUrl();
            if (is_array($url)) {
                $url['_return_url'] = $return;
            } elseif (is_string($url)) {
                $delimiter = strpos($url, '?') ? '&' : '?';
                $url .= $delimiter . http_build_query(['_return_url' => $return]);
            }
        }

        return parent::to($url, $scheme);
    }

    public static function returnUrl()
    {
        return Yii::$app->request->get('_return_url', Url::to());
    }

    /**
     * @param $text
     * @return array @array
     */
    public static function parseUrlFromText($text)
    {
        $url_pattern = "/\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/uxi";
        preg_match_all($url_pattern, $text, $m);

        return $m[0];
    }

}
