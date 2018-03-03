<?php

namespace app\models\behaviors;

use app\models\Partner;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class PartnerBehavior extends Behavior
{
    /**
     * @var Partner
     */
    public $owner;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeVadlidate',
            ActiveRecord::EVENT_BEFORE_INSERT  => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE  => 'beforeSave',
        ];
    }

    public function beforeVadlidate($event)
    {
        $partner = $this->owner;
        if ($partner->type == Partner::TYPE_PEOPLE) {
            $partner->name = trim($partner->lastname . ' ' . $partner->firstname);
        } else {
            $partner->firstname = 'fake';
            $partner->lastname = 'fake';
        }
    }
    
    public function beforeSave($event)
    {
        $partner = $this->owner;
        if ($partner->type != Partner::TYPE_PEOPLE) {
            $partner->firstname = null;
            $partner->lastname = null;
        }

        if ($partner->state_id && $partner->state_id != $partner->getOldAttribute('state_id')) {
            $partner->state = null;
        } elseif ($partner->state && $partner->state != $partner->getOldAttribute('state')) {
            $partner->state_id = null;
        }
    }
}