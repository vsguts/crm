<?php

namespace app\components\rbac;

use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params
 */
abstract class AbstractRule extends Rule
{
    public function init()
    {
        parent::init();
        
        $name = static::className();
        if ($pos = strrpos($name, '\\')) {
            $name = substr($name, $pos + 1);
        }
        
        $name = str_replace('Rule', '', $name);
        $this->name = strtolower($name);
    }
}
