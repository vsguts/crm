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
    
    public $idField = 'id';

    /**
     * Details link action
     * Need for app\widgets\grid\DataColumn
     * Need for app\widgets\grid\ActionColumn
     * 
     * @var bool|array
     */
    public $detailsLinkPopup = false;

    public $ajaxPager = false;

    public $enableLinks = true;

    public function init()
    {
        parent::init();
        
        if ($this->ajaxPager) {
            $this->pager['resultIds'] = $this->id;
        }
    }

    public function prepareDetailsLink($model)
    {
        $id = 0;
        if (is_object($model) && isset($model->{$this->idField})) {
            $id = $model->{$this->idField};
        } elseif (is_array($model) && isset($model[$this->idField])) {
            $id = $model[$this->idField];
        }

        $linkParams = [
            $this->idField => $id
        ];
        
        $options = [];

        if ($this->detailsLinkPopup) {
            $options['class'] = 'c-modal';
            $options['data-target-id'] = $this->controllerId . '_' . $id;
            $linkParams['_return_url'] = Url::to();
        }

        $options['href'] = $this->prepareCustomLink($this->detailsLinkAction, $linkParams);

        return $options;
    }

    public function prepareRemoveLink($model)
    {
        $id = 0;
        if (is_object($model) && isset($model->{$this->idField})) {
            $id = $model->{$this->idField};
        } elseif (is_array($model) && isset($model[$this->idField])) {
            $id = $model[$this->idField];
        }

        $options = [
            'href' => $this->prepareCustomLink('delete', [$this->idField => $id]),
            'data-confirm' => __('Are you sure you want to delete this item?'),
            'data-method' => 'post',
        ];

        return $options;
    }

    public function prepareCustomLink($action, $linkParams = [])
    {
        $linkRoute = $action;
        // Override controller
        if ($this->controllerId) {
            $linkRoute = '/' . $this->controllerId . '/' . $linkRoute;
        }

        return Url::to(array_merge([$linkRoute], $linkParams));
    }

}
