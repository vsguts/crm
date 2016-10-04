<?php

namespace app\widgets\grid;

use app\widgets\grid\Column;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Inflector;

class CounterColumn extends DataColumn
{
    public $label;

    public $count;

    public $showEmpty = true;

    // Deprecated:

    public $countField = null;
    
    public $modelClass = null;
    
    public $modelField;
    
    public $urlPath;
    
    public $searchFieldName = null;
    
    public $needUrl = true;
    
    public $dirtyUrl = false;

    protected function renderHeaderCellContent()
    {
        return $this->label;
    }

    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->count) {
            $count = call_user_func($this->count, $model, $key, $index, $this);
        
        // Deprecated: use `self::$count`
        } elseif ($this->countField) {
            $count = $model->{$this->countField};
        } elseif ($this->modelClass) {
            $childModelClass = $this->modelClass;
            $count = $childModelClass::find()->where([$this->modelField => $key])->permission()->count();
        } else {
            throw new Exception("Count is empty");
        }

        if (empty($count) && !$this->showEmpty) {
            return '';
        }

        $content = Html::tag('span', $count, ['class' => 'badge']);

        // Deprecated: Use `DataColumn::$link`
        if ($this->needUrl && $this->modelClass && $this->modelField) { // need url
            $childModel = new $childModelClass;
            if (empty($this->urlPath)) {
                $this->urlPath = Inflector::camel2id($childModel->formName()) . '/index';
            }
            if (empty($this->searchFieldName)) {
                $this->searchFieldName = $this->modelField;
                if ($this->dirtyUrl) {
                    $this->searchFieldName = $childModel->formName().'Search['.$this->modelField.']';
                }
            }

            $url = Url::to([$this->urlPath, $this->searchFieldName => $key]);
            return Html::a($content, $url);
        }
        
        return $this->dataCellContentWrapper($content, $model);
    }
}