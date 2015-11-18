<?php

namespace app\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\models\MailingList;

class MailingListBehavior extends Behavior
{
    public $mailingListIds;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND    => 'eventFind',
            ActiveRecord::EVENT_AFTER_INSERT  => 'eventUpdate',
            ActiveRecord::EVENT_AFTER_UPDATE  => 'eventUpdate',
        ];
    }

    public function rules()
    {
        return [
            [['mailingListIds'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'mailingListIds' => __('Mailing lists'),
        ];
    }

    public function eventFind($event)
    {
        $this->mailingListIds = [];
        foreach ($this->owner->mailingLists as $list) {
            $this->mailingListIds[] = $list->id;
        }
    }

    public function eventUpdate($event)
    {
        $model = $this->owner;

        $model->unlinkAll('mailingLists', true);
        if ($this->mailingListIds) {
            $lists = MailingList::findAll($this->mailingListIds);
            foreach ($lists as $list) {
                $model->link('mailingLists', $list);
            }
        }
    }

    public function processContent($content, $model)
    {
        return preg_replace_callback('/\{([a-z.0-9]+)\}/Sui', function($m) use($model) {
            $parts = explode('.', $m[1]);
            $result = $model;
            foreach ($parts as $part) {
                if (is_object($result) && isset($result->$part)) {
                    $result = $result->$part;
                }
            }

            if (is_object($result)) {
                return '';
            }
            return $result;
        }, $content);
    }

}
