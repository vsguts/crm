<?php

namespace common\widgets\form;

use yii\base\Widget;
use yii\helpers\Html;
use yii\db\ActiveRecord;

class ButtonsContatiner extends Widget
{
    public $model;
    
    public $footerWrapper = false;
    
    public $form = '';
    
    public $removeLink = false;
    
    public $saveLink = true;

    public $create = null;

    // Extras

    public $beforeBtn = [];

    public $afterBtn = [];

    public function run()
    {
        if ($this->footerWrapper) {
            echo Html::beginTag('div', ['class' => 'form-group panel-footer']);
        }
        
        $submit_options = [];
        if ($this->form) {
            $submit_options['form'] = $this->form;
        }

        echo $this->displayPart($this->beforeBtn) . '&nbsp;';

        $afterBtn = '';
        if ($this->afterBtn) {
            $afterBtn = '&nbsp;' . $this->displayPart($this->afterBtn);
        }

        if (
            $this->create === true
            || $this->model instanceof ActiveRecord && $this->model->isNewRecord
        ) {
            if ($this->saveLink) {
                $submit_options['class'] = 'btn btn-success';
                echo Html::submitButton(__('Create'), $submit_options);
            }
            
            echo $afterBtn;
        } else {
            if ($this->saveLink) {
                $submit_options['class'] = 'btn btn-primary';
                echo Html::submitButton(__('Update'), $submit_options);
            }

            echo $afterBtn;

            if ($this->removeLink) {
                echo ' ';
                echo Html::a(__('Delete'), ['delete', 'id' => $this->model->id], [
                    'class' => 'btn btn-danger',
                    'data-confirm' => __('Are you sure you want to delete this item?'),
                    'data-method' => 'post'
                ]);
            }
        }

        if ($this->footerWrapper) {
            echo Html::endTag('div');
        }
    }

    protected function displayPart($part)
    {
        return implode(' ', (array)$part);
    }
}
