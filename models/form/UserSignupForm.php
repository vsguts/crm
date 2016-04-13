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
    public $email;
    public $name;
    public $password;

    const PASS_MIN_LEN = 4;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => __('This email address has already been taken.')],

            ['name', 'required'],
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => static::PASS_MIN_LEN],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => __('Email'),
            'name' => __('Name'),
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
            $user->email = $this->email;
            $user->name = $this->name;
            $user->password = $this->password;
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
