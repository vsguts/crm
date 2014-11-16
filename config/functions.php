<?php

function __()
{
    $args = array_merge(
        ['app'],
        func_get_args()
    );
    return call_user_func_array(['Yii', 't'], $args);
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
        fn_echo($prefix);
        foreach ($args as $k => $v) {

            if (defined('CONSOLE')) {
                fn_echo(print_r($v, true));
            } else {
                fn_echo('<li><pre>' . htmlspecialchars(print_r($v, true)) . "\n" . '</pre></li>');
            }
        }
        fn_echo($suffix);

        if (defined('AJAX_REQUEST')) {
            $ajax_vars = Registry::get('ajax')->getAssignedVars();
            if (!empty($ajax_vars['debug_info'])) {
                $args = array_merge($ajax_vars['debug_info'], $args);
            }
            Registry::get('ajax')->assign('debug_info', $args);
        }
    }
    $count++;
}

function pd()
{
    $args = func_get_args();
    call_user_func_array('p', $args);
    die();
}

function fn_echo($value)
{
    if (defined('CONSOLE')) {
        $value = str_replace(array('<br>', '<br />', '<br/>'), "\n", $value);
        $value = strip_tags($value);
    }

    echo($value);

    fn_flush();
}

function fn_flush()
{
    if (function_exists('ob_flush')) {
        @ob_flush();
    }

    flush();
}

