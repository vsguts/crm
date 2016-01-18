<?php

namespace app\widgets;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Url;

class Attachments extends InputWidget
{
    public function run()
    {
        $attachments = $this->model->getAttachments();
        if (!$attachments) {
            return '';
        }

        $name = Html::getInputName($this->model, $this->attribute);

        echo Html::beginTag('table', ['class' => 'table']);
        $headers = [
            Html::tag('th', __('Filename')),
            Html::tag('th', __('File size')),
            Html::tag('th', __('Delete')),
        ];
        echo Html::tag('tr', implode(' ', $headers));
        foreach ($attachments as $attachment) {
            $columns = [
                Html::tag('td', Html::a($attachment->filename, $attachment->getUrl(), ['target' => '_blank'])),
                Html::tag('td', Yii::$app->formatter->asShortSize($attachment->filesize)),
                Html::tag('td', Html::checkbox($name . '[' . $attachment->id . '][delete]', false)),
            ];
            echo Html::tag('tr', implode(PHP_EOL, $columns));
        }
        echo Html::endTag('table');
    }

}
