<?php

namespace app\models;

use Yii;

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
