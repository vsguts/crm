<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\Partner;
use app\models\MailingList;

class MailingListAppendPartner extends Model
{
    public $partner_ids;
    public $mailing_list_id;

    public function rules()
    {
        return [
            [['mailing_list_id'], 'required'],
            [['mailing_list_id'], 'integer'],
            [['partner_ids'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'mailing_list_id' => __('Mailing list'),
        ];
    }

    public function append()
    {
        $mailingList = MailingList::findOne($this->mailing_list_id);
        
        $partners = Partner::findAll(explode(',', $this->partner_ids));
        foreach ($partners as $partner) {
            $mailingList->unlink('partners', $partner, true);
            $mailingList->link('partners', $partner);
        }
        
        return true;
    }
    
}
