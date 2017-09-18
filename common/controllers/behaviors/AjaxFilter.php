<?php

namespace common\controllers\behaviors;

use common\components\html\Dom;
use Yii;
use yii\base\ActionFilter;

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
                /** @var Dom $dom */
                $dom = Yii::createObject([
                    'class' => Dom::class,
                    'html' => $res,
                ]);
                
                if (!empty($_REQUEST['target_id'])) {
                    $this->ajaxVars['html'] = $dom->getElementByIds($_REQUEST['target_id']);
                }

                if (empty($_REQUEST['except_scripts'])) {
                    list($scripts, $src) = $dom->getScripts();
                    if ($scripts) {
                        $this->ajaxVars['scripts'] = $scripts;
                    }
                    if ($src && 0) { // disabled
                        $this->ajaxVars['scripts_src'] = $src;
                    }
                }

            }

            // Flashes
            if (!isset($this->ajaxVars['alerts'])) {
                if ($flashes = Yii::$app->session->getAllFlashes()) {
                    $this->ajaxVars['alerts'] = $flashes;
                }
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
