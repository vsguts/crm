<?php

namespace app\models;

use Yii;
use app\models\query\PartnerQuery;

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
 * @property string $city
 * @property string $address
 * @property string $zipcode
 * @property integer $parent_id
 * @property integer $volunteer
 * @property integer $candidate
 * @property string $notes
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Country $country
 * @property Donate[] $donates
 * @property MailingList[] $mailingList
 * @property MailingListPartner[] $mailingListPartners
 * @property Partner $parent
 * @property Partner[] $partners
 * @property PartnerTag[] $partnerTags
 * @property State $state0
 * @property Tag[] $tags
 * @property TaskPartner[] $taskPartners
 * @property Task[] $tasks
 * @property Visit[] $visits
 */
class Partner extends \yii\db\ActiveRecord
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
            'app\behaviors\LookupBehavior',
            'app\behaviors\ListBehavior',
            'app\behaviors\TagsBehavior',
            'yii\behaviors\TimestampBehavior',
            'app\behaviors\ImageUploaderBehavior',
            'app\behaviors\ImagesBehavior',
        ];
    }

    public function rules()
    {
        return [
            [['name', 'firstname', 'lastname'], 'required'],
            [['email'], 'email'],
            [['zipcode'], 'string', 'max' => 16],
            [['phone'], 'string', 'max' => 32],
            [['name', 'firstname', 'lastname', 'email', 'state', 'city'], 'string', 'max' => 64],
            [['contact'], 'string', 'max' => 128],
            [['address'], 'string', 'max' => 255],
            [['type', 'status', 'country_id', 'state_id', 'parent_id', 'volunteer', 'candidate'], 'integer'],
            [['notes'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
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
            'created_at' => __('Created At'),
            'updated_at' => __('Updated At'),
            'publicTags' => __('Public tags'),
            'personalTags' => __('Personal tags'),
            
            // From Behaviors. FIXME
            'imagesUpload' => __('Images upload'),
        ];
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
