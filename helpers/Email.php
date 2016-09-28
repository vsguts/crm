<?php

namespace app\helpers;

class Email
{

    public static function formatEmails($emails)
    {
        $result = array();
        foreach ((array) $emails as $email) {
            $email = str_replace(';', ',', $email);
            $res = explode(',', $email);
            foreach ($res as &$v) {
                $v = trim($v);
            }
            $res = array_filter($res);
            if ($res) {
                $result = array_merge($result, $res);
            }
        }

        return array_unique($result);
    }

}
