<?php

namespace app\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class ButtonsContatiner extends Widget
{
    public $model;

    public function run()
    {
        echo '<div class="form-group panel-footer">';
        if ($this->model->isNewRecord) {
            echo Html::submitButton(__('Create'), ['class' => 'btn btn-success']);
        } else {
            echo Html::submitButton(__('Update'), ['class' => 'btn btn-primary']);
            echo ' ';
            echo Html::a(__('Delete'), ['delete', 'id' => $this->model->id], [
                'class' => 'btn btn-danger',
                'data-confirm' => __('Are you sure you want to delete this item?'),
                'data-method' => 'post'
            ]);
        }
        echo '</div>';

    }
}