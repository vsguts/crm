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
            'app\behaviors\LookupBehavior',
            'app\behaviors\ListBehavior',
            'app\behaviors\TagsBehavior',
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['type', 'status', 'country_id', 'state_id', 'church_id', 'volunteer', 'candidate'], 'integer'],
            [['notes'], 'string'],
            [['name', 'email', 'state', 'address'], 'string', 'max' => 255],
            [['email'], 'email']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => __('ID'),
            'type' => __('Type'),
            'status' => __('Status'),
            'name' => __('Name'),
            'email' => __('Email'),
            'country_id' => __('Country'),
            'state_id' => __('State'),
            'state' => __('State'),
            'city' => __('City'),
            'address' => __('Address'),
            'church_id' => __('Church ID'),
            'volunteer' => __('Volunteer'),
            'candidate' => __('Candidate'),
            'notes' => __('Notes'),
            'created_at' => __('Created At'),
            'updated_at' => __('Updated At'),
            'publicTags' => __('Public tags'),
            'personalTags' => __('Personal tags'),
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

    public function getPublicTags()
    {
        return $this
            ->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->publicTags()
            ->viaTable('partner_tag', ['partner_id' => 'id']);
    }

    public function getPersonalTags()
    {
        return $this
            ->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->personalTags()
            ->viaTable('partner_tag', ['partner_id' => 'id']);
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
