<?php

function __()
{
    $args = array_merge(
        ['app'],
        func_get_args()
    );
    return call_user_func_array(['Yii', 't'], $args);
}

function getClassName($object)
{
    $name = get_class($object);
    return substr($name, strrpos($name, '\\') + 1);
}

/**
 * Debuging
 */

function p()
{
    static $count = 0;
    $args = func_get_args();

    if (defined('CONSOLE')) {
        $prefix = "\n";
        $suffix = "\n\n";
    } else {
        $prefix = '<ol style="font-family: Courier; font-size: 12px; border: 1px solid #dedede; background-color: #efefef; float: left; padding-right: 20px;">';
        $suffix = '</ol><div style="clear:left;"></div>';
    }

    if (!empty($args)) {
        if (Yii::$app && Yii::$app->has('request') && Yii::$app->getRequest()->getIsAjax()) {
            if ($debug = Yii::$app->controller->ajaxGet('debug')) {
                $args = array_merge($debug, $args);
            }

            Yii::$app->controller->ajaxAssign('debug', $args);
        } else {
            echo($prefix);
            foreach ($args as $k => $v) {

                if (defined('CONSOLE')) {
                    echo(print_r($v, true));
                } else {
                    echo('<li><pre>' . htmlspecialchars(print_r($v, true)) . "\n" . '</pre></li>');
                }
            }
            echo($suffix);
            $count++;
        }
    }

    if (function_exists('ob_flush')) {
        @ob_flush();
    }

    flush();
}

function pd()
{
    $args = func_get_args();
    call_user_func_array('p', $args);
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
