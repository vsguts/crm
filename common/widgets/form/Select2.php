<?php

namespace common\widgets\form;

use Closure;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\InputWidget;

class Select2 extends InputWidget
{
    /**
     * @var bool
     */
    public $multiline = false;

    /**
     * Ajax mode
     * @var array
     */
    public $url;

    /**
     * Non-Ajax mode
     * @var array
     */
    public $items = [];

    /**
     * @var array|Closure
     */
    public $relatedUrl;

    /**
     * Use in ajax single mode (non-multiline)
     * @var string
     */
    public $initValueText;

    /**
     * Use in ajax multiline mode
     * Current items: Key => Value
     * @var array
     */
    public $currentItems = [];

    public $disabled = false;

    public function init()
    {
        if ($this->items && $this->url) {
            throw new Exception('You must use url for ajax mode or items for non-ajax mode.');
        }

        Html::addCssClass($this->options, ['form-control', 'app-select2']);

        if ($this->url) {
            $this->options['data-app-url'] = Url::to($this->url);
            Html::addCssClass($this->options, 'app-select2-ajax');
        }

        if ($this->initValueText) {
            $this->options['data-init-value-text'] = $this->initValueText;
        }

        if (!isset($this->options['placeholder'])) {
            $this->options['placeholder'] = ' -- ';
        }

        if ($this->disabled) {
            $this->options['disabled'] = true;
        }

        parent::init();
    }

    public function run()
    {
        if ($this->multiline) {
            $extra_class = '';
            if ($this->currentItems) {
                $extra_class = 'app-item-template';
                foreach ($this->currentItems as $key => $value) {
                    if ($urlAttributes = $this->getRelatedUrlAttributes($key)) {
                        $value = Html::a($value, null, $urlAttributes);
                    }
                    $content = [
                        Html::tag('div', $value, ['class' => 'col-sm-11 form-control-static']),
                        Html::activeHiddenInput($this->model, $this->attribute, ['value' => $key]),
                        $this->multipleButtons(),
                    ];
                    echo Html::tag('div', implode(' ', $content), ['class' => 'row app-item']);
                }
            }

            echo Html::beginTag('div', ['class' => 'row app-item ' . $extra_class]);
            echo Html::beginTag('div', ['class' => 'col-sm-11']);
        }

        if ($this->hasModel()) {
            if ($this->url) { // Ajax mode
                $content = Html::activeTextInput($this->model, $this->attribute, $this->options);
            } else {
                $content = Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
            }
            if (!$this->multiline) {
                if ($urlAttributes = $this->getRelatedUrlAttributes()) {
                    $link = Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-link']), null, $urlAttributes);
                    $content = Html::tag('div', $content, ['class' => 'col-sm-11'])
                        . Html::tag('div', $link, ['class' => 'col-sm-1 form-control-static']);
                    $content = Html::tag('div', $content, ['class' => 'row']);
                }
            }
            echo $content;
        } else {
            if ($this->url) { // Ajax mode
                echo Html::textInput($this->name, $this->value, $this->options);
            } else {
                echo Html::dropDownList($this->name, $this->value, $this->items, $this->options);
            }
        }

        if ($this->multiline) {
            echo Html::endTag('div');
            echo $this->multipleButtons();
            echo Html::endTag('div');
        }
    }

    private function multipleButtons()
    {
        if ($this->disabled) {
            return;
        }

        $buttons = [
            Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']), ['class' => 'app-item-new']),
            Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash']), ['class' => 'app-item-remove']),
        ];

        $content = implode(' ' , $buttons);
        
        return Html::tag('div', $content, ['class' => 'col-sm-1 form-control-static']);
    }

    private function getRelatedUrlAttributes($id = false)
    {
        if (!$this->relatedUrl) {
            return false;
        }

        if ($this->relatedUrl instanceof Closure) {
            return call_user_func($this->relatedUrl, $id);
        } else {
            $url = $this->relatedUrl;
            if ($id) {
                $url['id'] = $id;
            }
            if (is_array($url)) {
                $url = Url::to($url);
            }
            return ['href' => $url];
        }
    }

}
