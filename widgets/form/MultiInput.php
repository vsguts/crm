<?php

namespace app\widgets\form;

use yii\helpers\Html;
use yii\widgets\InputWidget;

class MultiInput extends InputWidget
{
    /**
     * @var array
     */
    public $models = [];

    /**
     * @var \Closure
     */
    public $row;

    /**
     * @var int
     */
    public $cols = 11;

    public function run()
    {
        if ($this->models) {
            foreach ($this->models as $model) {
                $this->showRow($model);
            }
        } else {
            $this->showRow();
        }

        $this->showRow(null, true);
    }

    protected function showRow($model = null, $is_template = false)
    {
        $row_callback = $this->row;
        $row_content = $row_callback($model, $is_template);
        $content = [
            Html::tag('div', $row_content, ['class' => ['col-sm-' . $this->cols]]),
            $this->multipleButtons(),
        ];
        $classes = ['row', 'app-item', 'form-inline'];
        if ($is_template) {
            $classes[] = 'app-item-template';
        }
        echo Html::tag('div', implode(' ', $content), ['class' => $classes]);
    }

    protected function multipleButtons()
    {
        $buttons = [
            Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus']), ['class' => 'app-item-new']),
            Html::tag('a', Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash']), ['class' => 'app-item-remove']),
        ];

        $content = implode(' ' , $buttons);

        $cols = 12 - $this->cols;
        return Html::tag('div', $content, ['class' => ['col-sm-' . $cols, 'form-control-static']]);
    }

}
