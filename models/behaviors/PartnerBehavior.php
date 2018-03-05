<?php

namespace app\models\behaviors;

use app\models\Partner;
use yii\base\Behavior;
use yii\base\ModelEvent;
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
            ActiveRecord::EVENT_BEFORE_INSERT   => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_UPDATE   => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_DELETE   => 'beforeDelete',
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

    public function beforeDelete(ModelEvent $event)
    {
        $model = $this->owner;

        if ($model->getCommunications()->limit(1)->ids()) {
            $event->isValid = false;
            $model->addError('id', __('Can not delete: {message}', [
                'message' => __('Partner has communication')
            ]));
        }

        if ($model->getDonates()->limit(1)->ids()) {
            $event->isValid = false;
            $model->addError('id', __('Can not delete: {message}', [
                'message' => __('Partner has donates')
            ]));
        }

        if ($model->getTasks()->limit(1)->ids()) {
            $event->isValid = false;
            $model->addError('id', __('Can not delete: {message}', [
                'message' => __('Partner has tasks')
            ]));
        }
    }
}