<?php

namespace app\widgets\form;

use app\helpers\FileHelper;
use app\widgets\Tooltip;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class ActiveField extends \yii\bootstrap\ActiveField
{
    protected $tooltip = false;

    public function text(array $options = [])
    {
        $value = $this->prepareTextValue($options);
        $this->parts['{input}'] = Html::tag('p', $value, $options);

        return $this;
    }

    public function link($options = [], $linkOptions = [])
    {
        $value = $this->prepareTextValue($options);
        $this->parts['{input}'] = Html::tag('p', $value, $options);
        $this->parts['{error}'] = '';

        if (isset($options['privilege'])) {
            if (Yii::$app->user->can($options['privilege'])) {
                $this->parts['{input}'] = Html::tag('p', Html::a($value, null, $linkOptions), $options);
            }
        }

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

    /**
     * Need this because we have prepare value similar way in link and text methods
     *
     * @param $options
     * @return mixed
     */
    protected function prepareTextValue(& $options)
    {
        $options = array_merge($this->inputOptions, $options);
        $this->adjustLabelFor($options);
        Html::removeCssClass($options, 'form-control');
        Html::addCssClass($options, 'form-control-static');
        $value = isset($options['value']) ? $options['value'] : Html::getAttributeValue($this->model, $this->attribute);
        $method = 'asRaw';
        if (isset($options['format'])) {
            $method = 'as' . ucfirst($options['format']);
        }
        /** @deprecated */
        if (isset($options['formatter'])) {
            $method = 'as' . ucfirst($options['formatter']);
        }

        return Yii::$app->formatter->$method($value);
    }
}
