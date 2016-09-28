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

    public function getElementByIds($target_ids)
    {
        if (empty($target_ids) || empty($this->html)) {
            return [];
        }

        if (is_string($target_ids)) {
            $target_ids = explode(',', $target_ids);
        }

        $result = [];
        foreach ($target_ids as $target_id) {
            $target_id = trim($target_id);
            if (!isset($result[$target_id])) {
                // $elm = $xpath->query("//*[@id='" . $target_id . "']")->item(0); // several way
                if ($elm = $this->dom->getElementById($target_id)) {
                    $result[$target_id] = $this->dom->saveHTML($elm);
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