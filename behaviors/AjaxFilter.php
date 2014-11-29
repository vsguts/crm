<?php

namespace app\behaviors;

use Yii;
use yii\base\ActionFilter;

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
            Yii::$app->getResponse()->format = 'json';
            $return = $this->ajaxVars;
            
            $request = Yii::$app->getRequest();
            if (!empty($request->queryParams['result_ids'])) {
                $result_ids = explode(',', $request->queryParams['result_ids']);
                $return['html'] = $this->getDomElementById($res, $result_ids);
            }

            return $return;
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

    protected function getDomElementById($html, $result_ids = [])
    {
        if (empty($result_ids) || empty($html)) {
            return [];
        }

        if (is_string($result_ids)) {
            $result_ids = explode(',', $result_ids);
        }

        $dom = new \DOMDocument;
        libxml_use_internal_errors(true);
        $dom->loadHTML($html);
        libxml_clear_errors();
        // $xpath = new \DOMXPath($dom); // several way

        $result = [];
        foreach ($result_ids as $result_id) {
            $result_id = trim($result_id);
            if (!isset($result[$result_id])) {
                // $elm = $xpath->query("//*[@id='" . $result_id . "']")->item(0); // several way
                $elm = $dom->getElementById($result_id);
                $result[$result_id] = $dom->saveHTML($elm);
            }
        }
        return $result;
    }
}
