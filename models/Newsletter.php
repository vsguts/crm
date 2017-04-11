<?php

namespace app\models;

use app\models\behaviors\AttachmentsBehavior;
use app\models\behaviors\MailingListBehavior;
use app\models\behaviors\NewsletterBehavior;
use app\models\behaviors\TimestampBehavior;

/**
 * This is the model class for table "newsletter".
 *
 * @property integer $id
 * @property string $subject
 * @property string $body
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property NewsletterLog[] $newsletterLogs
 * @property NewsletterMailingList[] $newsletterMailingLists
 * @property MailingList[] $lists
 */
class Newsletter extends AbstractModel
{
    public static function tableName()
    {
        return 'newsletter';
    }
    
    public function behaviors()
    {
        return [
            MailingListBehavior::class,
            TimestampBehavior::class,
            NewsletterBehavior::class,
            AttachmentsBehavior::class,
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['subject'], 'required'],
            [['body'], 'string'],
            [['subject'], 'string', 'max' => 255],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id'      => __('ID'),
            'subject' => __('Subject'),
            'body'    => __('Body'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLogs()
    {
        return $this->hasMany(NewsletterLog::className(), ['newsletter_id' => 'id'])->inverseOf('newsletter');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsletterMailingLists()
    {
        return $this->hasMany(NewsletterMailingList::className(), ['newsletter_id' => 'id'])->inverseOf('newsletter');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailingLists()
    {
        return $this
            ->hasMany(MailingList::className(), ['id' => 'list_id'])
            ->viaTable('newsletter_mailing_list', ['newsletter_id' => 'id']);
    }

    public function getLogsCount()
    {
        return NewsletterLog::find()->where(['newsletter_id' => $this->id])->count();
    }

    public function getMailingListsCount()
    {
        return MailingList::find()->joinWith('newsletterMailingLists')->where(['newsletter_id' => $this->id])->count();
    }

}
