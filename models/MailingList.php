<?php

namespace app\models;

use Yii;
use app\models\query\MailingListQuery;

class MailingList extends AbstractModel
{
    public static function tableName()
    {
        return 'mailing_list';
    }

    public function behaviors()
    {
        return [
            'app\behaviors\PartnersSelectBehavior',
            'app\behaviors\LookupBehavior',
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name'], 'required'],
            [['status'], 'integer'],
            [['name', 'from_name', 'from_email', 'reply_to'], 'string', 'max' => 255],
            [['from_email', 'reply_to'], 'email'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => __('ID'),
            'name' => __('Name'),
            'from_name' => __('From name'),
            'from_email' => __('From email'),
            'reply_to' => __('Reply to'),
            'status' => __('Status'),
        ]);
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

    public function getPrintTemplateMailingLists()
    {
        return $this->hasMany(PrintTemplateMailingList::className(), ['list_id' => 'id']);
    }

    public function getTemplates()
    {
        return $this
            ->hasMany(PrintTemplate::className(), ['id' => 'template_id'])
            ->viaTable('print_template_mailing_list', ['list_id' => 'id']);
    }

    public static function find()
    {
        return new MailingListQuery(get_called_class());
    }

}
