<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "newsletter".
 *
 * @property integer $id
 * @property string $subject
 * @property string $body
 *
 * @property NewsletterLog[] $logs
 * @property NewsletterMailingList[] $newsletterMailingLists
 * @property MailingList[] $mailingList
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
            'app\behaviors\MailingListBehavior',
            'app\behaviors\TimestampBehavior',
            'app\behaviors\ListBehavior',
            'app\behaviors\NewsletterBehavior',
            'app\behaviors\AttachmentsBehavior',
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

    public function getLogs()
    {
        return $this->hasMany(NewsletterLog::className(), ['newsletter_id' => 'id']);
    }

    public function getNewsletterMailingLists()
    {
        return $this->hasMany(NewsletterMailingList::className(), ['newsletter_id' => 'id']);
    }

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
