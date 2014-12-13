<?php

namespace app\behaviors;

use yii\base\Behavior;

class SearchBehavior extends Behavior
{
    public function processParams($params)
    {
        $form_name = $this->owner->formName();
        $_params = $params;
        unset($_params[$form_name]);
        unset($_params['r']);
        $params[$form_name] = array_merge(
            $_params,
            isset($params[$form_name]) ? $params[$form_name] : []
        );
        
        return $params;
    }
}