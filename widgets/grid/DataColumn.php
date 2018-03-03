<?php

namespace app\widgets\grid;

use yii\helpers\Html;

class DataColumn extends \yii\grid\DataColumn
{
    /**
     * @var GridView
     */
    public $grid;

    /**
     * Link options
     * @var \Closure
     */
    public $link = false;

    public function init()
    {
        parent::init();

        if ($this->grid->ajaxPager) {
            $this->sortLinkOptions['class'] = 'app-ajax';
            $this->sortLinkOptions['data-target-id'] = $this->grid->id;
        }
    }

    protected function renderDataCellContent($model, $key, $index)
    {
        $text = parent::renderDataCellContent($model, $key, $index);

        return $this->dataCellContentWrapper($text, $model);
    }

    protected function dataCellContentWrapper($content, $model)
    {
        if ($options = $this->getLinkOptions($model)) {
            $url = null;
            if (is_string($options)) {
                $url = $options;
                $options = [];
            }
            $content = Html::a($content, $url, $options);
        }

        return $content;
    }

    protected function getLinkOptions($model)
    {
        if (
            $this->link
            && is_callable($this->link)
        ) {
            $options = call_user_func($this->link, $model);
            if (is_string($options)) {
                $options = ['href' => $options];
            }
            return $options;
        }
    }

}
