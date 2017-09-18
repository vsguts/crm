<?php

namespace common\models\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use common\models\Partner;

class PartnersSelectBehavior extends Behavior
{
    public $partners_ids = [];

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'update',
            ActiveRecord::EVENT_AFTER_UPDATE => 'update',
        ];
    }

    public function rules()
    {
        return [
            [['partners_ids'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'partners_ids' => __('Partners'),
        ];
    }

    public function update($event)
    {
        $model = $this->owner;

        $ids = array_filter($this->partners_ids);

        $current_ids = [];
        foreach ($model->partners as $partner) {
            $current_ids[] = $partner->id;
        }

        if ($ids_new = array_diff($ids, $current_ids)) {
            foreach (Partner::findAll($ids_new) as $partner) {
                $model->link('partners', $partner);
            }
        }

        if ($ids_removed = array_diff($current_ids, $ids)) {
            foreach (Partner::findAll($ids_removed) as $partner) {
                $model->unlink('partners', $partner, true);
            }
        }
    }

}
