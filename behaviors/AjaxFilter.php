<?php

namespace app\behaviors;

use Yii;
use yii\base\ActionFilter;
use app\components\Dom;

class AjaxFilter extends ActionFilter
{
    public $ajaxMode = false;
    
    protected $ajaxVars = [];

    public function beforeAction($action)
    {
        if (Yii::$app->getRequest()->getIsAjax()) {
            $this->ajaxMode = true;
        }
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        $res = parent::afterAction($action, $result);

        if ($this->ajaxMode) {
            $dom = Yii::createObject([
                'class' => Dom::className(),
                'html' => $res,
            ]);
            
            $request = Yii::$app->getRequest();
            if (!empty($request->queryParams['result_ids'])) {
                $result_ids = explode(',', $request->queryParams['result_ids']);
                $this->ajaxVars['html'] = $dom->getElementByIds($result_ids);
            }

            list($scripts, $src) = $dom->getScripts();
            if ($scripts) {
                $this->ajaxVars['scripts'] = $scripts;
            }
            if ($scripts) {
                $this->ajaxVars['scripts_src'] = $src;
            }

            Yii::$app->getResponse()->format = 'json';
            return $this->ajaxVars;
        } else {
            return $res;
        }
    }

    public function ajaxAssign($name, $var = null)
    {
        if ($this->ajaxMode) {
            $this->ajaxVars[$name] = $var;
        }
    }

    public function ajaxGet($name)
    {
        if ($this->ajaxMode && isset($this->ajaxVars[$name])) {
            return $this->ajaxVars[$name];
        }
    }

}
