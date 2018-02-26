<?php

namespace app\widgets\grid;

class GridView extends \yii\grid\GridView
{

    public $dataColumnClass = 'app\widgets\grid\DataColumn';

    public $layout = "{pager}\n{items}\n{pager}";

    public $tableOptions = ['class' => 'table table-striped table-hover table-highlighted'];

    public $pager = [
        'class' => 'app\widgets\grid\LinkPager',
    ];

    public $ajaxPager = false;

    public $customHeader = null;

    public function init()
    {
        parent::init();

        if ($this->ajaxPager) {
            $this->pager['linkOptions']['class'] = 'app-ajax';
            $this->pager['linkOptions']['data-target-id'] = $this->id;
        }
    }

    public function renderTableHeader()
    {
        if ($this->customHeader) {
            $cells = [];
            foreach ($this->columns as $column) {
                $cells[] = $column->renderHeaderCell();
            }
            $content = preg_replace_callback('/\{column([0-9]+)\}/Sui', function($m) use($cells){
                $index = $m[1] - 1;
                return isset($cells[$index]) ? $cells[$index] : '';
            }, $this->customHeader);

            if ($this->filterPosition === self::FILTER_POS_HEADER) {
                $content = $this->renderFilters() . $content;
            } elseif ($this->filterPosition === self::FILTER_POS_BODY) {
                $content .= $this->renderFilters();
            }

            return "<thead>\n" . $content . "\n</thead>";
        } else {
            return parent::renderTableHeader();
        }
    }

}
