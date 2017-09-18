<?php

namespace common\widgets;

use yii\helpers\Html;
use yii\bootstrap\Modal as BModal;

class Modal extends BModal
{
    public $id;

    public $btn_close = true;

    public $options = ['class' => '']; // disable fade
    
    public $clientOptions = false;

    public function init()
    {
        if ($this->id) {
            $this->options['id'] = $this->id;
        }

        if ($this->header) {
            $this->header = Html::tag('h4', $this->header, ['class' => 'modal-title']);
        }

        if ($this->btn_close) {
            $close_btn = Html::tag('button', __('Close'), [
                'type' => 'button',
                'class' => 'btn btn-default',
                'data-dismiss' => 'modal'
            ]);
            $this->footer .= PHP_EOL . $close_btn;
        }

        parent::init();
    }
}
