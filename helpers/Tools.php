<?php

namespace app\helpers;

use Closure;

class Tools
{
    public static function doRepeat(Closure $callback, $times = 10, $delay = 10)
    {
        $iteration = 1;
        $needRequest = true;

        while ($needRequest && $iteration <= $times) {
            try {
                $needRequest = false;
                $result = call_user_func($callback);
            } catch (\Exception $e) {
                echo 'Tools: Repeat: Error: ' . $e . PHP_EOL;
                $error = $e;
                $needRequest = true;
                $iteration ++;
                sleep($delay);
            }
        }

        if ($needRequest) {
            throw $error;
        }

        return $result;
    }
}
