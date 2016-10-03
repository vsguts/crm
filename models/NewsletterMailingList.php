<?php

namespace app\models;

use Yii;

class NewsletterMailingList extends AbstractModel
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
