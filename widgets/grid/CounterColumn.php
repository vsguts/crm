<?php

namespace app\widgets\grid;

use yii\grid\Column;
use yii\helpers\Html;
use yii\helpers\Url;

class CounterColumn extends Column
{
    public $label;
    public $modelClass;
    public $modelField;
    public $controllerName;
    public $searchFieldName;
    
    protected function renderHeaderCellContent()
    {
        return $this->label;
    }

    protected function renderDataCellContent($model, $key, $index)
    {
        $childModelClass = $this->modelClass;

        $count = $childModelClass::find()->where([$this->modelField => $key])->count();
        
        $childModel = new $childModelClass;
        if (empty($this->controllerName)) {
            $this->controllerName = $childModel->formName();
        }
        if (empty($this->searchFieldName)) {
            $this->searchFieldName = $childModel->formName().'Search['.$this->modelField.']';
        }

        $url = Url::to([strtolower($this->controllerName) . '/index', $this->searchFieldName => $key]);
        
        return Html::a('<span class="badge">' . $count . '</span>', $url);
    }
}