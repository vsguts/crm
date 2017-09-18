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
 * Debuging
 */

/**
 * Print
 */
function p()
{
    $args = func_get_args();

    // Ajax
    if (
        Yii::$app
        && property_exists(Yii::$app, 'controller')
        && Yii::$app->controller
        && !empty(Yii::$app->controller->ajaxMode)
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

/**
 * Print and Die
 */
function pd()
{
    if (
        Yii::$app
        && property_exists(Yii::$app, 'controller')
        && Yii::$app->controller
        && !empty(Yii::$app->controller->ajaxMode)
    ) {
        Yii::$app->controller->ajaxMode = false;
    }

    $args = func_get_args();
    call_user_func_array('p', $args);

    // Flush
    if (function_exists('ob_flush')) {
        @ob_flush();
    }
    flush();

    die();
}

/**
 * Print and Log
 */
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

/**
 * Print and Log: Simple
 * @param $item
 */
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
