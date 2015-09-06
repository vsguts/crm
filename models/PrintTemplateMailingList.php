<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "print_template_mailing_list".
 *
 * @property integer $template_id
 * @property integer $list_id
 *
 * @property MailingList $list
 * @property PrintTemplate $template
 */
class PrintTemplateMailingList extends AModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'print_template_mailing_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'list_id'], 'required'],
            [['template_id', 'list_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'template_id' => Yii::t('app', 'Template ID'),
            'list_id' => Yii::t('app', 'List ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getList()
    {
        return $this->hasOne(MailingList::className(), ['id' => 'list_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(PrintTemplate::className(), ['id' => 'template_id']);
    }
}
