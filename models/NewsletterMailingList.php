<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "newsletter_mailing_list".
 *
 * @property integer $newsletter_id
 * @property integer $list_id
 *
 * @property MailingList $mailingList
 * @property Newsletter $newsletter
 */
class NewsletterMailingList extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'newsletter_mailing_list';
    }

    public function rules()
    {
        return [
            [['newsletter_id', 'list_id'], 'required'],
            [['newsletter_id', 'list_id'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'newsletter_id' => __('Newsletter ID'),
            'list_id' => __('List ID'),
        ];
    }

    public function getMailingList()
    {
        return $this->hasOne(MailingList::className(), ['id' => 'list_id']);
    }

    public function getNewsletter()
    {
        return $this->hasOne(Newsletter::className(), ['id' => 'newsletter_id']);
    }
}
