<?php

namespace app\models;

use Yii;

class MailingListPartner extends AbstractModel
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getList()
    {
        return $this->hasOne(MailingList::className(), ['id' => 'list_id'])->inverseOf('mailingListPartners');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id'])->inverseOf('mailingListPartners');
    }

}
