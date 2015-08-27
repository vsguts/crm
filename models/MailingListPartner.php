<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mailing_list_partner".
 *
 * @property integer $list_id
 * @property integer $partner_id
 *
 * @property Partner $partner
 * @property MailingList $mailingList
 */
class MailingListPartner extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'mailing_list_partner';
    }

    public function rules()
    {
        return [
            [['list_id', 'partner_id'], 'required'],
            [['list_id', 'partner_id'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'list_id' => __('List ID'),
            'partner_id' => __('Partner ID'),
        ];
    }

    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    public function getMailingList()
    {
        return $this->hasOne(MailingList::className(), ['id' => 'list_id']);
    }
}
