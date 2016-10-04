<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use app\models\form\UserSignupForm;

class User extends AbstractModel implements \yii\web\IdentityInterface
{
    const AUTH_ROLE_1 = 'user';
    const AUTH_ROLE_2 = 'root';
    const AUTH_ROLE_3 = 'missionary';
    const AUTH_ROLE_4 = 'accountant';
    const AUTH_ROLE_5 = 'manager';

    const STATUS_ACTIVE = 1;

    public $password;

    public static function tableName()
    {
        return 'user';
    }
    
    public function behaviors()
    {
        return [
            'app\behaviors\UserPasswordBehavior',
            'app\behaviors\UserRolesBehavior',
            'app\behaviors\TimestampBehavior',
            'app\behaviors\LookupBehavior',
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

    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['user_id' => 'id']);
    }

    public function getTemplates()
    {
        return $this->hasMany(Template::className(), ['user_id' => 'id']);
    }

    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    public function getState0()
    {
        return $this->hasOne(State::className(), ['id' => 'state_id']);
    }

    public function getDonates()
    {
        return $this->hasMany(Donate::className(), ['user_id' => 'id']);
    }

    public function getVisits()
    {
        return $this->hasMany(Visit::className(), ['user_id' => 'id']);
    }

    public function getNewsletterLogs()
    {
        return $this->hasMany(NewsletterLog::className(), ['user_id' => 'id']);
    }


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
    
}
