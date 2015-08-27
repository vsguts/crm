<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mailing_list".
 *
 * @property integer $id
 * @property string $name
 * @property string $from_name
 * @property string $from_email
 * @property string $reply_to
 *
 * @property MailingListPartner[] $mailingListPartners
 * @property Partner[] $partners
 * @property NewsletterMailingList[] $newsletterMailingLists
 * @property Newsletter[] $newsletters
 */
class MailingList extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'mailing_list';
    }

    public function behaviors()
    {
        return [
            'app\behaviors\PartnersSelectBehavior',
        ];
    }

    public function rules()
    {
        return [
            [['name', 'from_email'], 'required'],
            [['name', 'from_name', 'from_email', 'reply_to'], 'string', 'max' => 255],
            [['from_email', 'reply_to'], 'email'],
            [['partners_ids'], 'safe'], //FIXME
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => __('ID'),
            'name' => __('Name'),
            'from_name' => __('From name'),
            'from_email' => __('From email'),
            'reply_to' => __('Reply to'),

            // FIXME
            'partners_ids' => __('Partners'),
        ];
    }

    public function getMailingListPartners()
    {
        return $this->hasMany(MailingListPartner::className(), ['list_id' => 'id']);
    }

    public function getPartners()
    {
        return $this
            ->hasMany(Partner::className(), ['id' => 'partner_id'])
            ->viaTable('mailing_list_partner', ['list_id' => 'id']);
    }

    public function getPartnersCount()
    {
        return Partner::find()->joinWith('mailingListPartners')->where(['list_id' => $this->id])->count();
    }

    public function getNewsletterMailingLists()
    {
        return $this->hasMany(NewsletterMailingList::className(), ['list_id' => 'id']);
    }

    public function getNewsletters()
    {
        return $this
            ->hasMany(Newsletter::className(), ['id' => 'newsletter_id'])
            ->viaTable('newsletter_mailing_list', ['list_id' => 'id']);
    }
}
