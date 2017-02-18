<?php

namespace app\models;

use app\models\query\MailingListQuery;

/**
 * This is the model class for table "mailing_list".
 *
 * @property integer $id
 * @property string $name
 * @property string $from_name
 * @property string $from_email
 * @property string $reply_to
 * @property integer $status
 *
 * @property MailingListPartner[] $mailingListPartners
 * @property Partner[] $partners
 * @property NewsletterMailingList[] $newsletterMailingLists
 * @property Newsletter[] $newsletters
 * @property PrintTemplateMailingList[] $printTemplateMailingLists
 * @property PrintTemplate[] $templates
 */
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailingListPartners()
    {
        return $this->hasMany(MailingListPartner::className(), ['list_id' => 'id'])->inverseOf('list');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsletterMailingLists()
    {
        return $this->hasMany(NewsletterMailingList::className(), ['list_id' => 'id'])->inverseOf('list');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsletters()
    {
        return $this
            ->hasMany(Newsletter::className(), ['id' => 'newsletter_id'])
            ->viaTable('newsletter_mailing_list', ['list_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrintTemplateMailingLists()
    {
        return $this->hasMany(PrintTemplateMailingList::className(), ['list_id' => 'id'])->inverseOf('list');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplates()
    {
        return $this
            ->hasMany(PrintTemplate::className(), ['id' => 'template_id'])
            ->viaTable('print_template_mailing_list', ['list_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return MailingListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MailingListQuery(get_called_class());
    }

}
