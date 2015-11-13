<?php
namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Signup form
 */
class UserSignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    const PASS_MIN_LEN = 4;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => User::className(), 'message' => __('This username has already been taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => __('This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => static::PASS_MIN_LEN],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => __('Username'),
            'email' => __('Email'),
            'password' => __('Password'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->password = $this->password;
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
