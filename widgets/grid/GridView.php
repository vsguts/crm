<?php

namespace app\widgets\grid;

use yii\helpers\Url;
use yii\grid\GridView as YGridView;

class GridView extends YGridView
{
    
    public $dataColumnClass = 'app\widgets\grid\DataColumn';

    public $layout = "{pager}\n{items}\n{pager}";
    
    public $tableOptions = ['class' => 'table table-striped'];

    public $pager = [
        'class' => 'app\widgets\Pager',
    ];

    /**
     * For links
     * 
     * @var string
     */
    public $controllerId;
    
    /**
     * Details link action
     * Need for app\widgets\grid\DataColumn
     * Need for app\widgets\grid\ActionColumn
     * 
     * @var string
     */
    public $detailsLinkAction = 'update';

    /**
     * Details link action
     * Need for app\widgets\grid\DataColumn
     * Need for app\widgets\grid\ActionColumn
     * 
     * @var bool|array
     */
    public $detailsLinkPopup = false;

    public $ajaxPager = false;

    public function init()
    {
        parent::init();
        
        if ($this->ajaxPager) {
            $this->pager['resultIds'] = $this->id;
        }
    }

    public function prepareDetailsLink($id)
    {
        $linkRoute = $this->detailsLinkAction;
        $linkParams = [
            'id' => $id
        ];
        
        // Override controller
        if ($this->controllerId) {
            $linkRoute = '/' . $this->controllerId . '/' . $linkRoute;
        }

        $options = [];

        if ($this->detailsLinkPopup) {
            $options['class'] = 'c-modal';
            $options['data-target-id'] = $this->controllerId . '_' . $id;
            $linkParams['_return_url'] = Url::to();
        }

        $options['href'] = Url::to(array_merge([$linkRoute], $linkParams));

        return $options;
    }

    public function prepareRemoveLink($id)
    {
        $linkRoute = 'delete';
        $linkParams = [
            'id' => $id
        ];
        
        // Override controller
        if ($this->controllerId) {
            $linkRoute = '/' . $this->controllerId . '/' . $linkRoute;
        }

        $options = [
            'href' => Url::to(array_merge([$linkRoute], $linkParams)),
            'data-confirm' => __('Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ];

        return $options;
    }

}