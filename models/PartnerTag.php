<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "partner_tag".
 *
 * @property integer $partner_id
 * @property integer $tag_id
 *
 * @property Partner $partner
 * @property Tag $tag
 */
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
