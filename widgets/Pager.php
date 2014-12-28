<?php

namespace app\widgets;

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\bootstrap\ButtonDropdown;

class Pager extends LinkPager
{
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
        $per_page_items = range($min_page_size, $max_page_size, 10);
        foreach ($per_page_items as $per_page_item) {
            $items[] = [
                'label' => $per_page_item,
                'url' => $this->pagination->createUrl(1, $per_page_item),
                'active' => $per_page_item == $current_page_size,
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
