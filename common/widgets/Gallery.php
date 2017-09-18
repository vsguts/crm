<?php

namespace common\widgets;

use dosamigos\gallery\Gallery as DGallery;

class Gallery extends DGallery
{
    public function run()
    {
        if (empty($this->items)) {
            return null;
        }
        echo $this->renderItems();
        // echo $this->renderTemplate(); // Disabled. Render it later
        $this->registerClientScript();
    }
}