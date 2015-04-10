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
 * @property integer $city
 * @property string $address
 * @property string $zipcode
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
    const TYPE_ORG = 1;
    const TYPE_CHURCH = 2;
    const TYPE_PEOPLE = 3;

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
            'app\behaviors\PartnerNameBehavior',
            'app\behaviors\LookupBehavior',
            'app\behaviors\ListBehavior',
            'app\behaviors\TagsBehavior',
            'yii\behaviors\TimestampBehavior',
            'app\behaviors\ImageUploaderBehavior',
            'app\behaviors\ImagesBehavior',
        ];
    }

    /**
     * @inheritdoc
     */
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
            [['type', 'status', 'country_id', 'state_id', 'church_id', 'volunteer', 'candidate'], 'integer'],
            [['notes'], 'safe'],
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
            'church_id' => __('Church'),
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
     * @inheritdoc
     * @return PartnerQuery
     */
    public static function find()
    {
        return new PartnerQuery(get_called_class());
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
