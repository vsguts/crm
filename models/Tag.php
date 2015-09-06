<?php

namespace app\models;

use Yii;
use app\models\query\TagQuery;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 *
 * @property PartnerTag[] $partnerTags
 * @property Partner[] $partners
 * @property User $user
 */
class Tag extends AModel
{
    public static function tableName()
    {
        return 'tag';
    }

    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    public function getPartnerTags()
    {
        return $this->hasMany(PartnerTag::className(), ['tag_id' => 'id']);
    }

    public function getPartners()
    {
        return $this->hasMany(Partner::className(), ['id' => 'partner_id'])->viaTable('partner_tag', ['tag_id' => 'id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getPartnersCount()
    {
        return Partner::find()->joinWith('tags')->where(['tag_id' => $this->id])->count();
    }

    /**
     * @inheritdoc
     * @return TagQuery
     */
    public static function find()
    {
        return new TagQuery(get_called_class());
    }

    public function setToPersonal()
    {
        $this->user_id = Yii::$app->user->getId() ?: 0;
    }

    // Garbage collector
    public function gc()
    {
        $partners = $this->partners;
        if (empty($partners)) {
            $this->delete();
        }
    }

}
