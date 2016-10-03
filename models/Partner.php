<?php

namespace app\models;

use Yii;
use app\models\query\PartnerQuery;

class Partner extends AbstractModel
{
    const TYPE_PEOPLE = 1;
    const TYPE_ORG = 2;
    const TYPE_NPO = 3;
    const TYPE_CHURCH = 4;

    public static function tableName()
    {
        return 'partner';
    }

    public function behaviors()
    {
        return [
            'app\behaviors\PartnerNameBehavior',
            'app\behaviors\TagsBehavior',
            'app\behaviors\TimestampBehavior',
            'app\behaviors\ImageUploaderBehavior',
            'app\behaviors\ImagesBehavior',
            'app\behaviors\ListBehavior',
            'app\behaviors\LookupBehavior',
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'firstname', 'lastname'], 'required'],
            [['email'], 'email'],
            [['zipcode'], 'string', 'max' => 16],
            [['phone'], 'string', 'max' => 32],
            [['name', 'firstname', 'lastname', 'email', 'state', 'city'], 'string', 'max' => 64],
            [['contact'], 'string', 'max' => 128],
            [['address'], 'string', 'max' => 255],
            [['type', 'status', 'country_id', 'state_id', 'parent_id', 'volunteer', 'candidate'], 'integer'],
            [['notes'], 'safe'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => __('ID'),
            'type' => __('Type'),
            'status' => __('Status'),
            'name' => __('Name'),
            'firstname' => __('First name'),
            'lastname' => __('Last name'),
            'contact' => __('Contact person'),
            'email' => __('Email'),
            'phone' => __('Phone'),
            'country_id' => __('Country'),
            'state_id' => __('State'),
            'state' => __('State'),
            'city' => __('City'),
            'address' => __('Address'),
            'zipcode' => __('Zip/postal code'),
            'parent_id' => __('Member'),
            'volunteer' => __('Volunteer'),
            'candidate' => __('Candidate'),
            'notes' => __('Notes'),
        ]);
    }

    public function getDonates()
    {
        return $this->hasMany(Donate::className(), ['partner_id' => 'id']);
    }

    public function getParent()
    {
        return $this->hasOne(Partner::className(), ['id' => 'parent_id']);
    }

    public function getPartners()
    {
        return $this->hasMany(Partner::className(), ['parent_id' => 'id']);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    public function getState0()
    {
        return $this->hasOne(State::className(), ['id' => 'state_id']);
    }

    public function getPartnerTags()
    {
        return $this->hasMany(PartnerTag::className(), ['partner_id' => 'id']);
    }

    public function getTags()
    {
        return $this
            ->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('partner_tag', ['partner_id' => 'id']);
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

    public function getTaskPartners()
    {
        return $this->hasMany(TaskPartner::className(), ['partner_id' => 'id']);
    }

    public function getTasks()
    {
        return $this
            ->hasMany(Task::className(), ['id' => 'task_id'])
            ->viaTable('task_partner', ['partner_id' => 'id']);
    }

    public function getVisits()
    {
        return $this->hasMany(Visit::className(), ['partner_id' => 'id']);
    }

    public function getMailingListPartners()
    {
        return $this->hasMany(MailingListPartner::className(), ['partner_id' => 'id']);
    }

    public function getMailingLists()
    {
        return $this
            ->hasMany(MailingList::className(), ['id' => 'list_id'])
            ->viaTable('mailing_list_partner', ['partner_id' => 'id']);
    }

    public static function find()
    {
        return new PartnerQuery(get_called_class());
    }

}
