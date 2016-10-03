<?php

namespace app\models;

use Yii;

class PrintTemplateMailingList extends AbstractModel
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
            'template_id' => __('Template'),
            'list_id' => __('List'),
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
