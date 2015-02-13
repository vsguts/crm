<?php

namespace app\components;

use yii\base\Object;

class Dom extends Object
{
    public $html;

    protected $dom;

    public function init()
    {
        $this->dom = new \DOMDocument;
        if (!empty($this->html)) {
            libxml_use_internal_errors(true);
            $this->dom->loadHTML($this->encodeHtml($this->html));
            libxml_clear_errors();
            // $xpath = new \DOMXPath($this->dom); // several way
        }
    }

    public function getElementByIds($result_ids)
    {
        if (empty($result_ids) || empty($this->html)) {
            return [];
        }

        if (is_string($result_ids)) {
            $result_ids = explode(',', $result_ids);
        }

        $result = [];
        foreach ($result_ids as $result_id) {
            $result_id = trim($result_id);
            if (!isset($result[$result_id])) {
                // $elm = $xpath->query("//*[@id='" . $result_id . "']")->item(0); // several way
                if ($elm = $this->dom->getElementById($result_id)) {
                    $result[$result_id] = $this->dom->saveHTML($elm);
                }
            }
        }
        return $result;
    }

    public function getScripts()
    {
        $scripts = [];
        $scripts_src = [];
        foreach ($this->dom->getElementsByTagName('script') as $script) {
            if ($src = $script->getAttribute('src')) {
                $scripts_src[] = $src;
            } else { // inline
                $scripts[] = $this->decodeHtml($script->nodeValue);
            }
        }
        
        return [$scripts, $scripts_src];
    }

    protected function encodeHtml($html)
    {
        return mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
    }

    protected function decodeHtml($html)
    {
        return mb_convert_encoding($html, 'UTF-8', 'HTML-ENTITIES');
    }

}