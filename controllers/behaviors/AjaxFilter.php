<?php

namespace app\controllers\behaviors;

use Yii;
use yii\base\ActionFilter;
use app\components\html\Dom;

class AjaxFilter extends ActionFilter
{
    public $ajaxMode = false;
    
    protected $ajaxVars = [];

    public function beforeAction($action)
    {
        if ($this->getIsAjax()) {
            $this->ajaxMode = true;
        }
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result)
    {
        $res = parent::afterAction($action, $result);

        if ($this->ajaxMode) {
            if ($res) {
                $dom = Yii::createObject([
                    'class' => Dom::className(),
                    'html' => $res,
                ]);
                
                if (!empty($_REQUEST['target_id'])) {
                    $target_id = explode(',', $_REQUEST['target_id']);
                    $this->ajaxVars['html'] = $dom->getElementByIds($target_id);
                }

                list($scripts, $src) = $dom->getScripts();
                if ($scripts) {
                    $this->ajaxVars['scripts'] = $scripts;
                }
                if ($src && 0) { // disabled
                    $this->ajaxVars['scripts_src'] = $src;
                }

            }

            // Flashes
            if (!isset($this->ajaxVars['alerts'])) {
                $this->ajaxVars['alerts'] = Yii::$app->session->getAllFlashes();
            }

            Yii::$app->response->format = 'json';
            return $this->ajaxVars;
        }

        return $res;
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

    public function getIsAjax()
    {
        return Yii::$app->getRequest()->getIsAjax();
    }

}
