<?php

namespace common\models;

use common\models\behaviors\TimestampBehavior;
use Yii;
use yii\behaviors\AttributeBehavior;

/**
 * This is the model class for table "newsletter_log".
 *
 * @property integer $id
 * @property integer $newsletter_id
 * @property integer $user_id
 * @property integer $timestamp
 * @property string $content
 *
 * @property Newsletter $newsletter
 * @property User $user
 */
class NewsletterLog extends AbstractModel
{
    public static function tableName()
    {
        return 'newsletter_log';
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => 'user_id',
                ],
                'value' => function ($event) {
                    return Yii::$app->user->identity->id;
                },
            ],
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['timestamp'],
                ],
            ],
        ];
    }

    public function rules()
    {
        return [
            [['newsletter_id', 'user_id', 'timestamp'], 'integer'],
            [['content'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => __('ID'),
            'newsletter_id' => __('Newsletter'),
            'user_id' => __('User'),
            'timestamp' => __('Time'),
            'content' => __('Content'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsletter()
    {
        return $this->hasOne(Newsletter::className(), ['id' => 'newsletter_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
