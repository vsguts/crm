<?php

function __()
{
    $args = array_merge(
        ['app'],
        func_get_args()
    );
    return call_user_func_array(['Yii', 't'], $args);
}

// Using in cycles
function app_in_range($max, &$from, &$to, $iteration_items = 100)
{
    if (empty($from)) {
        $from = 0;
    }
    if (empty($to)) {
        $to = 0;
    }

    if ($to > $max) {
        return false;
    }

    if ($from != $to && !empty($to)) {
        $from = $to;
    }

    $to = $from + $iteration_items;

    return true;
}

/**
 * Gets the value of an environment variable.
 *
 * @param  string  $key
 * @param  mixed   $default
 * @return mixed
 */
function env($key, $default = null)
{
    $value = getenv($key);

    if ($value === false) {
        return $default;
    }

    switch (strtolower($value)) {
        case 'true':
        case '(true)':
            return true;
        case 'false':
        case '(false)':
            return false;
        case 'empty':
        case '(empty)':
            return '';
        case 'null':
        case '(null)':
            return;
    }

    if (($valueLength = strlen($value)) > 1 && $value[0] === '"' && $value[$valueLength - 1] === '"') {
        return substr($value, 1, -1);
    }

    return $value;
}

/**
 * Debuging
 */

function p()
{
    $args = func_get_args();
    
    // Ajax
    if (
        Yii::$app
        && Yii::$app->has('request')
        && Yii::$app->getRequest() instanceof yii\web\Request
        && Yii::$app->getRequest()->getIsAjax()
    ) {
        
        if ($debug = Yii::$app->controller->ajaxGet('debug')) {
            $args = array_merge($debug, $args);
        }

        Yii::$app->controller->ajaxAssign('debug', $args);
    
    // Console
    } elseif (
        Yii::$app
        && Yii::$app->has('request')
        && Yii::$app->getRequest() instanceof yii\console\Request
    ) {

        echo(PHP_EOL);
        foreach ($args as $v) {
            echo(print_r($v, true) . PHP_EOL);
        }
        echo(PHP_EOL);

    // Web
    } else {

        echo('<ol style="font-family: Courier; font-size: 12px; border: 1px solid #dedede; background-color: #efefef; float: left; padding-right: 20px;">');
        foreach ($args as $v) {
            echo('<li><pre>' . htmlspecialchars(print_r($v, true)) . "\n" . '</pre></li>');
        }
        echo('</ol><div style="clear:left;"></div>');

    }
}

function pd()
{
    $args = func_get_args();
    call_user_func_array('p', $args);

    // Flush
    if (function_exists('ob_flush')) {
        @ob_flush();
    }
    flush();

    die();
}

function plog()
{
    $file = __DIR__ . '/../plog.log';
    
    $resource = fopen($file, 'a');
    if ($resource) {
        $content = PHP_EOL . print_r(array_merge([
            'time' => date('Y-m-d H:i:s'),
        ], func_get_args()), 1);
        fwrite($resource, $content);
    }
    fclose($resource);
}

function plog_simple($item)
{
    $file = __DIR__ . '/../plog_simple.log';
    
    $resource = fopen($file, 'a');
    if ($resource) {
        $content = PHP_EOL . print_r($item, 1);
        fwrite($resource, $content);
    }
    fclose($resource);
}
