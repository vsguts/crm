<?php

namespace app\widgets;

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ButtonDropdown;

class Pager extends LinkPager
{
    public $resultIds = '';

    public function init()
    {
        parent::init();

        // Enable ajax
        if ($this->resultIds) {
            $this->linkOptions['class'] = 'app-ajax';
            $this->linkOptions['data-result-ids'] = $this->resultIds;
        }
    }

    public function run()
    {
        parent::run();

        $this->renderPerPageSelector();
    }

    public function renderPerPageSelector()
    {
        $page_count = $this->pagination->getPageCount();
        if ($page_count < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $current_page_size = $this->pagination->getPageSize();
        
        list($min_page_size, $max_page_size) = $this->pagination->pageSizeLimit;

        if ($min_page_size < 10) {
            $min_page_size = 10;
        }

        $items = [];

        $_max_page_size = ($max_page_size > 100) ? 100 : $max_page_size;
        $per_page_items = range($min_page_size, $_max_page_size, 10);
        
        if ($max_page_size > 100) {
            $_per_page_items = range(100, $max_page_size, 100);
            unset($_per_page_items[0]);
            $per_page_items = array_merge($per_page_items, $_per_page_items);
        }

        foreach ($per_page_items as $per_page_item) {
            $items[] = [
                'label' => $per_page_item,
                'url' => $this->pagination->createUrl(1, $per_page_item),
                'active' => $per_page_item == $current_page_size,
                'linkOptions' => $this->linkOptions,
            ];
        }
        
        $dropdown = ButtonDropdown::widget([
            'options' => ['class' => 'btn-default'],
            'label' => $current_page_size,
            'dropdown' => [
                'items' => $items,
            ],
        ]);

        $content = __('Total items: <b>{items}</b>', ['items' => $this->pagination->totalCount]);
        $content .= ' / ' . $dropdown;

        $content = Html::tag('div', $content);
        echo Html::tag('div', $content, ['class' => 'pagination-per-page']);
    }
}
