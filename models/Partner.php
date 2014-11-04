<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "partner".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $status
 * @property string $name
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property integer $country_id
 * @property integer $state_id
 * @property string $state
 * @property integer $city
 * @property string $address
 * @property integer $church_id
 * @property integer $volunteer
 * @property integer $candidate
 * @property string $notes
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Donate[] $donates
 * @property Country $country
 * @property State $state0
 * @property PartnerTag[] $partnerTags
 * @property Tag[] $tags
 * @property Task[] $tasks
 * @property Template[] $templates
 * @property Visit[] $visits
 */
class Partner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partner';
    }

    public function behaviors()
    {
        return [
            'lookup' => [
                'class' => 'app\behaviors\LookupBehavior',
            ],
            'list' => [
                'class' => 'app\behaviors\ListBehavior',
            ],
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'status', 'country_id', 'state_id', 'city', 'church_id', 'volunteer', 'candidate'], 'integer'],
            [['notes'], 'string'],
            [['name', 'firstname', 'lastname', 'email', 'state', 'address'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
            'name' => Yii::t('app', 'Name'),
            'firstname' => Yii::t('app', 'Firstname'),
            'lastname' => Yii::t('app', 'Lastname'),
            'email' => Yii::t('app', 'Email'),
            'country_id' => Yii::t('app', 'Country ID'),
            'state_id' => Yii::t('app', 'State ID'),
            'state' => Yii::t('app', 'State'),
            'city' => Yii::t('app', 'City'),
            'address' => Yii::t('app', 'Address'),
            'church_id' => Yii::t('app', 'Church ID'),
            'volunteer' => Yii::t('app', 'Volunteer'),
            'candidate' => Yii::t('app', 'Candidate'),
            'notes' => Yii::t('app', 'Notes'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonates()
    {
        return $this->hasMany(Donate::className(), ['partner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState0()
    {
        return $this->hasOne(State::className(), ['id' => 'state_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartnerTags()
    {
        return $this->hasMany(PartnerTag::className(), ['partner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('partner_tag', ['partner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['partner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this->hasMany(Template::className(), ['partner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVisits()
    {
        return $this->hasMany(Visit::className(), ['partner_id' => 'id']);
    }

    /**
     * Lookup
     */
    public function getStatusName()
    {
        return $this->getLookupItem('status', $this->status);
    }

    public function getTypeName()
    {
        return $this->getLookupItem('type', $this->type);
    }

}
