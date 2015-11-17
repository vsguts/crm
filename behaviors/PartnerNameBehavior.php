<?php

namespace app\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\models\Partner;

class PartnerNameBehavior extends Behavior
{
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
    }

    public function getExtendedName()
    {
        $partner = $this->owner;

        $fields = [
            $partner->city,
            // $partner->getLookupItem('type', $partner->type),
        ];

        $fields = array_filter($fields);

        $result = $partner->name;

        if ($fields) {
            $result .= sprintf(' (%s)', implode(', ', $fields));
        }

        return $result;
    }

}