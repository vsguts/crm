<?php

namespace app\models;

use app\models\behaviors\TimestampBehavior;
use app\models\behaviors\UserPasswordBehavior;
use app\models\behaviors\UserRolesBehavior;
use app\models\components\LookupTrait;
use app\models\form\UserSignupForm;
use app\models\query\UserQuery;
use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $status
 * @property integer $country_id
 * @property integer $state_id
 * @property string $state
 * @property string $city
 * @property string $address
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Communication[] $communications
 * @property Donate[] $donates
 * @property NewsletterLog[] $newsletterLogs
 * @property Partner[] $partners
 * @property Tag[] $tags
 * @property Task[] $tasks
 * @property Country $country
 * @property State $state0
 */
class User extends AbstractModel implements IdentityInterface
{
    use LookupTrait;

    const STATUS_ACTIVE = 1;

    public $password;

    public static function tableName()
    {
        return 'user';
    }
    
    public function behaviors()
    {
        return [
            UserPasswordBehavior::class,
            UserRolesBehavior::class,
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return [
            [['name', 'email', 'password', 'auth_key', 'password_hash'], 'required'],
            [['email'], 'unique', 'message' => __('This email address has already been taken.')],
            [['email'], 'email'],
            [['password'], 'string', 'min' => UserSignupForm::PASS_MIN_LEN],
            [['status', 'country_id', 'state_id'], 'integer'],
            [['name', 'email', 'password_hash', 'password_reset_token', 'state', 'address'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32]
        ];
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => __('ID'),
            'name' => __('Name'),
            'email' => __('E-mail'),
            'password' => __('Password'),
            'status' => __('Status'),
            'country_id' => __('Country'),
            'state_id' => __('State'),
            'state' => __('State'),
            'city' => __('City'),
            'address' => __('Address'),
        ]);
    }


    /**
     * Relations
     */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id'])->inverseOf('users');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getState0()
    {
        return $this->hasOne(State::class, ['id' => 'state_id'])->inverseOf('users');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDonates()
    {
        return $this->hasMany(Donate::class, ['user_id' => 'id'])->inverseOf('user');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsletterLogs()
    {
        return $this->hasMany(NewsletterLog::class, ['user_id' => 'id'])->inverseOf('user');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartners()
    {
        return $this->hasMany(Partner::class, ['user_id' => 'id'])->inverseOf('user');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['user_id' => 'id'])->inverseOf('user');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::class, ['user_id' => 'id'])->inverseOf('user');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommunications()
    {
        return $this->hasMany(Communication::class, ['user_id' => 'id'])->inverseOf('user');
    }


    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }


    /**
     * IdentityInterface
     */

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function canManage()
    {
        if (Yii::$app->user->can('user_manage_own', ['user' => $this])) {
            return true;
        }
        return Yii::$app->user->can('user_manage');
    }

}
