<?php

namespace app\models;

use Yii;

class PartnerTag extends AbstractModel
{
    public static function tableName()
    {
        return 'partner_tag';
    }

    public function rules()
    {
        return [
            [['partner_id', 'tag_id'], 'required'],
            [['partner_id', 'tag_id'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'partner_id' => __('Partner'),
            'tag_id' => __('Tag'),
        ];
    }

    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}
