<?php

namespace app\components\rbac;

use yii\helpers\Inflector;
use yii\rbac\Rule;

abstract class AbstractRule extends Rule
{
    public function init()
    {
        parent::init();
        
        $name = get_class($this);
        if ($pos = strrpos($name, '\\')) {
            $name = substr($name, $pos + 1);
        }
        
        $name = str_replace('Rule', '', $name);
        $this->name = Inflector::camel2id($name, '_');
    }
}
