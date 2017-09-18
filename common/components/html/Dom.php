<?php

namespace common\components\html;

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

    public function getElementByIds($targetIds)
    {
        if (empty($targetIds) || empty($this->html)) {
            return [];
        }
        $targetIds = $this->prepareTargetIds($targetIds);

        $result = [];
        foreach ($targetIds as $targetId) {
            $targetId = trim($targetId);
            if (!isset($result[$targetId])) {
                // $elm = $xpath->query("//*[@id='" . $target_id . "']")->item(0); // several way
                if ($elm = $this->dom->getElementById($targetId)) {
                    $result[$targetId] = $this->dom->saveHTML($elm);
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

    private function encodeHtml($html)
    {
        return mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
    }

    private function decodeHtml($html)
    {
        return mb_convert_encoding($html, 'UTF-8', 'HTML-ENTITIES');
    }

    private function prepareTargetIds($targetIds)
    {
        if (is_string($targetIds)) {
            $targetIds = explode(',', $targetIds);
        }
        return $targetIds;
    }

}
