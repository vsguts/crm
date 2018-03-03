<?php

namespace app\widgets;

use Yii;
use yii\base\Model;
use yii\base\Widget;

abstract class AbstractLinkWidget extends Widget
{
    /**
     * Search model
     * @var Model
     */
    public $model;
    public $dependentModels;
    public $linkOptions = [
        'class' => 'btn btn-link',
    ];
    public $linkActiveClass = 'strong';

    protected $path;
    protected $formName;

    public function init()
    {
        parent::init();

        $this->path = Yii::$app->controller->route;

        $this->formName = '';
        if ($this->model) {
            $this->formName = $this->model->formName();
        }
    }

    /**
     * @param array|mixed ...$fields
     * @return array|mixed
     */
    protected function prepareQuery(...$fields)
    {
        $query = Yii::$app->request->queryParams;
        if (!$this->dependentModels) {
            return $query;
        }

        $fieldsValues = [];

        foreach ($this->dependentModels as $model) {
            if ($formName = $model->formName()) {
                foreach ($fields as $field) {
                    if (isset($query[$formName][$field])) {
                        $fieldsValues[$field][] = $query[$formName][$field];
                        unset($query[$formName][$field]);
                    }
                }
            }
        }

        // If we have dependentModels and there are two equal timestamps we take first of them and use it as default
        // out of form name
        foreach ($fieldsValues as $key => $values) {
            if (count(array_unique($values)) === 1) {
                $query[$key] = reset($values);
            }
        }

        return $query;
    }
}
