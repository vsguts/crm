<?php

namespace common\widgets\form;

use common\helpers\FileHelper;
use common\widgets\Tooltip;
use Yii;
use yii\bootstrap\ActiveField as YActiveField;
use yii\helpers\Html;
use yii\helpers\Url;

class ActiveField extends YActiveField
{
    protected $tooltip = false;

    public function text($options = [])
    {
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        Html::removeCssClass($options, 'form-control');
        Html::addCssClass($options, 'form-control-static');
        $value = isset($options['value']) ? $options['value'] : Html::getAttributeValue($this->model, $this->attribute);
        $method = 'asRaw';
        if (isset($options['formatter'])) {
            $method = 'as' . ucfirst($options['formatter']);
        }
        $value = Yii::$app->formatter->$method($value);
        if (!empty($options['linkOptions'])) {
            $value = Html::a($value, null, $options['linkOptions']);
        }
        $this->parts['{input}'] = Html::tag('p', $value, $options);
        $this->parts['{error}'] = '';

        return $this;
    }

    public function tooltip($tooltip)
    {
        $this->tooltip = $tooltip;
        return $this;
    }

    public function label($label = null, $options = [])
    {
        if ($this->tooltip) {
            $options = array_merge($this->labelOptions, $options);
            $options['label'] = $this->model->getAttributeLabel(Html::getAttributeName($this->attribute));
            $options['label'] .= ' ' . Tooltip::widget(['tooltip' => $this->tooltip]);
            $this->parts['{label}'] = Html::activeLabel($this->model, $this->attribute, $options);
            return $this;
        }

        return parent::label($label, $options);
    }

    public function attachment($options = [])
    {
        $model = $this->model;
        $attribute = $this->attribute;

        $this->fileInput($options);

        if ($model->$attribute) {
            $this->hint(Html::a(
                $model->$attribute,
                Url::to(['download', 'id' => $model->id, 'field' => $attribute]),
                ['target' => FileHelper::canShow($model->getPath($attribute)) ? '_blank' : '_self']
            ));
        }

        return $this;
    }
}
