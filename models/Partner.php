<?php

namespace app\models;

use app\models\behaviors\ImagesBehavior;
use app\models\behaviors\ImageUploaderBehavior;
use app\models\behaviors\PartnerBehavior;
use app\models\behaviors\TagsBehavior;
use app\models\behaviors\TimestampBehavior;
use app\models\components\LookupTrait;
use app\models\query\PartnerQuery;
use Yii;

/**
 * This is the model class for table "partner".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $country_id
 * @property integer $state_id
 * @property integer $parent_id
 * @property integer $type
 * @property integer $status
 * @property string $name
 * @property string $firstname
 * @property string $lastname
 * @property string $contact
 * @property string $email
 * @property string $phone
 * @property string $state
 * @property string $city
 * @property string $address
 * @property string $zipcode
 * @property integer $volunteer
 * @property integer $candidate
 * @property string $notes
 * @property string $communication_method
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Communication[] $communications
 * @property Donate[] $donates
 * @property MailingListPartner[] $mailingListPartners
 * @property MailingList[] $lists
 * @property Country $country
 * @property Partner $parent
 * @property Partner[] $partners
 * @property State $state0
 * @property User $user
 * @property PartnerTag[] $partnerTags
 * @property Tag[] $tags
 * @property TaskPartner[] $taskPartners
 * @property Task[] $tasks
 *
 * @mixin ImageUploaderBehavior
 * @mixin ImagesBehavior
 */
class Partner extends AbstractModel
{
    use LookupTrait;

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
            PartnerBehavior::class,
            TagsBehavior::class,
            TimestampBehavior::class,
            ImageUploaderBehavior::class,
            ImagesBehavior::class,
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            // Defaults
            [['user_id'], 'default', 'value' => Yii::$app->user->identity->id],

            // Common
            [['user_id', 'country_id', 'state_id', 'parent_id', 'type', 'status', 'volunteer', 'candidate'], 'integer'],
            [['notes'], 'string'],
            [['user_id', 'name', 'firstname', 'lastname'], 'required'],
            [['email'], 'email'],
            [['name', 'firstname', 'lastname', 'email', 'state', 'city', 'communication_method'], 'string', 'max' => 64],
            [['contact'], 'string', 'max' => 128],
            [['phone'], 'string', 'max' => 32],
            [['address'], 'string', 'max' => 255],
            [['zipcode'], 'string', 'max' => 16],

            // Relations
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::class, 'targetAttribute' => ['country_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Partner::class, 'targetAttribute' => ['parent_id' => 'id']],
            [['state_id'], 'exist', 'skipOnError' => true, 'targetClass' => State::class, 'targetAttribute' => ['state_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => __('ID'),
            'user_id' => __('User'),
            'country_id' => __('Country'),
            'state_id' => __('State'),
            'type' => __('Type'),
            'status' => __('Status'),
            'name' => __('Name'),
            'firstname' => __('First name'),
            'lastname' => __('Last name'),
            'contact' => __('Contact person'),
            'email' => __('Email'),
            'phone' => __('Phone'),
            'state' => __('State'),
            'city' => __('City'),
            'address' => __('Address'),
            'zipcode' => __('Zip/postal code'),
            'parent_id' => __('Member'),
            'volunteer' => __('Volunteer'),
            'candidate' => __('Candidate'),
            'notes' => __('Notes'),
            'communication_method' => __('Communication method'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id'])->inverseOf('partners');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id'])->inverseOf('partners');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState0()
    {
        return $this->hasOne(State::class, ['id' => 'state_id'])->inverseOf('partners');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Partner::class, ['id' => 'parent_id'])->inverseOf('partners');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonates()
    {
        return $this->hasMany(Donate::class, ['partner_id' => 'id'])->inverseOf('partner');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartners()
    {
        return $this->hasMany(Partner::class, ['parent_id' => 'id'])->inverseOf('parent');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartnerTags()
    {
        return $this->hasMany(PartnerTag::class, ['partner_id' => 'id'])->inverseOf('partner');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this
            ->hasMany(Tag::class, ['id' => 'tag_id'])
            ->viaTable('partner_tag', ['partner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPublicTags()
    {
        return $this
            ->hasMany(Tag::class, ['id' => 'tag_id'])
            ->publicTags()
            ->viaTable('partner_tag', ['partner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonalTags()
    {
        return $this
            ->hasMany(Tag::class, ['id' => 'tag_id'])
            ->personalTags()
            ->viaTable('partner_tag', ['partner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTaskPartners()
    {
        return $this->hasMany(TaskPartner::class, ['partner_id' => 'id'])->inverseOf('partner');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this
            ->hasMany(Task::class, ['id' => 'task_id'])
            ->viaTable('task_partner', ['partner_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunications()
    {
        return $this->hasMany(Communication::class, ['partner_id' => 'id'])->inverseOf('partner');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailingListPartners()
    {
        return $this->hasMany(MailingListPartner::class, ['partner_id' => 'id'])->inverseOf('partner');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailingLists()
    {
        return $this
            ->hasMany(MailingList::class, ['id' => 'list_id'])
            ->viaTable('mailing_list_partner', ['partner_id' => 'id']);
    }


    /**
     * @inheritdoc
     * @return PartnerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PartnerQuery(get_called_class());
    }


    /**
     * Extra
     */

    public function getIsOwn()
    {
        return $this->getIsNewRecord() || Yii::$app->user->id == $this->user_id;
    }

    public function canManage()
    {
        $user = Yii::$app->user;
        if ($this->getIsOwn()) {
            return $user->can('partner_manage_own');
        } else {
            return $user->can('partner_manage');
        }
    }

}
