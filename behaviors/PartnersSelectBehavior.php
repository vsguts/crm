<?php

namespace app\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\models\Partner;

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

    public function update($event)
    {
        $model = $this->owner;

        $ids = array_filter($this->partners_ids);

        $current_ids = [];
        foreach ($model->partners as $partner) {
            $current_ids[] = $partner->id;
        }

        $ids_new = array_diff($ids, $current_ids);
        foreach ($ids_new as $id) {
            $partner = Partner::findOne($id);
            $model->link('partners', $partner);
        }

        $ids_removed = array_diff($current_ids, $ids);
        foreach ($ids_removed as $id) {
            $partner = Partner::findOne($id);
            $model->unlink('partners', $partner, true);
        }
    }

}
