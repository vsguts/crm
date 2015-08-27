<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "newsletter".
 *
 * @property integer $id
 * @property string $subject
 * @property string $body
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property NewsletterMailingList[] $newsletterMailingLists
 * @property MailingList[] $mailingList
 */
class Newsletter extends \yii\db\ActiveRecord
{
    public $mailingListIds;

    public static function tableName()
    {
        return 'newsletter';
    }
    
    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'app\behaviors\ListBehavior',
        ];
    }

    public function rules()
    {
        return [
            [['subject'], 'required'],
            [['body'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['subject'], 'string', 'max' => 255],
            [['mailingListIds'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => __('ID'),
            'subject' => __('Subject'),
            'body' => __('Body'),
            'created_at' => __('Created At'),
            'updated_at' => __('Updated At'),
            'mailingListIds' => __('Mailing lists'),
        ];
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

    public function getMailingListsCount()
    {
        return MailingList::find()->joinWith('newsletterMailingLists')->where(['newsletter_id' => $this->id])->count();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->unlinkAll('mailingLists', true);
        if ($this->mailingListIds) {
            $models = MailingList::findAll($this->mailingListIds);
            foreach ($models as $model) {
                $this->link('mailingLists', $model);
            }
        }
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->mailingListIds = [];
        foreach ($this->mailingLists as $list) {
            $this->mailingListIds[] = $list->id;
        }
    }
}
