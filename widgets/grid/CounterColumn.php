<?php

namespace app\widgets\grid;

use yii\grid\Column;
use yii\helpers\Html;
use yii\helpers\Url;

class CounterColumn extends Column
{
    public $label;
    public $countField = null;
    public $modelClass = null;
    public $modelField;
    public $controllerName;
    public $searchFieldName = null;
    
    protected function renderHeaderCellContent()
    {
        return $this->label;
    }

    protected function renderDataCellContent($model, $key, $index)
    {
        if ($this->countField) {
            $count = $model->{$this->countField};
        } elseif ($this->modelClass) {
            $childModelClass = $this->modelClass;
            $count = $childModelClass::find()->where([$this->modelField => $key])->count();
        } else {
            throw new \Exception("Count is empty");
        }

        $content = Html::tag('span', $count, ['class' => 'badge']);

        if ($this->modelClass && $this->modelField) { // need url
            $childModel = new $childModelClass;
            if (empty($this->controllerName)) {
                $this->controllerName = $childModel->formName();
            }
            if (empty($this->searchFieldName)) {
                $this->searchFieldName = $childModel->formName().'Search['.$this->modelField.']';
            }

            $url = Url::to([strtolower($this->controllerName) . '/index', $this->searchFieldName => $key]);
            return Html::a($content, $url);
        }
        
        return $content;
    }
}