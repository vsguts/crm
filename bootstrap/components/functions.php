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

function log_echo($string, $filename = null)
{
    if (!$string) {
        return false;
    }

    $log_dir = DIR_ROOT . VAR_PATH . '/var/log/';
    fn_mkdir($log_dir);
    
    if (empty($filename)) {
        $filename = CONTROLLER . '.' . MODE;
    }

    $fd = fopen($log_dir . $filename . '.log', 'ab');
    if ($fd) {
        fwrite($fd, $string);
        fclose($fd);
    }

    fn_echo($string);
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
