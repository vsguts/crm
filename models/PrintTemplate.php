<?php

namespace app\models;

use Yii;
use app\models\query\PrintTemplateQuery;

class PrintTemplate extends AbstractModel
{
    public static function tableName()
    {
        return 'print_template';
    }

    public function behaviors()
    {
        return [
            'app\behaviors\MailingListBehavior',
            'app\behaviors\TimestampBehavior',
            'app\behaviors\LookupBehavior',
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'format', 'content'], 'required'],
            [['content', 'wrapper'], 'string'],
            [['status', 'wrapper_enabled', 'orientation_landscape', 'margin_top', 'margin_bottom', 'margin_left', 'margin_right'], 'integer'],
            [['margin_top', 'margin_bottom'], 'default', 'value' => 16],
            [['margin_left', 'margin_right'], 'default', 'value' => 15],
            [['wrapper'], 'default', 'value' => '{content}'],
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => __('ID'),
            'name' => __('Name'),
            'content' => __('Content'),
            'wrapper' => __('Wrapper'),
            'wrapper_enabled' => __('Enable wrapper'),
            'orientation_landscape' => __('Landscape orientation'),
            'margin_top' => __('Margin top (mm)'),
            'margin_bottom' => __('Margin bottom (mm)'),
            'margin_left' => __('Margin left (mm)'),
            'margin_right' => __('Margin right (mm)'),
            'status' => __('Status'),
            'format' => __('Format'),
        ]);
    }

    public function getPrintTemplateMailingLists()
    {
        return $this->hasMany(PrintTemplateMailingList::className(), ['template_id' => 'id']);
    }

    public function getMailingLists()
    {
        return $this
            ->hasMany(MailingList::className(), ['id' => 'list_id'])
            ->viaTable('print_template_mailing_list', ['template_id' => 'id']);
    }

    public function getMailingListsCount()
    {
        return MailingList::find()->joinWith('printTemplateMailingLists')->where(['template_id' => $this->id])->count();
    }

    /**
     * @inheritdoc
     * @return PrintTemplateQuery
     */
    public static function find()
    {
        return new PrintTemplateQuery(get_called_class());
    }

    /**
     * Print
     */
    public function generate()
    {
        $content = [];
        $partners = Partner::find()->viaMailingLists($this->mailingLists)->all();
        foreach ($partners as $partner) {
            $content[] = $this->processContent($this->content, $partner);
        }
        $content = implode(' ', $content);

        if ($this->wrapper_enabled) {
            $content = preg_replace('/\{content\}/Sui', $content, $this->wrapper);
        }

        return $content;
    }

    public function prepareOptions()
    {
        $options = [];
        
        $options['page-size'] = $this->format;
        
        // Margins
        foreach (['top', 'bottom', 'left', 'right'] as $margin) {
            $field = 'margin_' . $margin;
            if (isset($this->$field)) {
                $options['margin-' . $margin] = $this->$field;
            }
        }

        $options['orientation'] = $this->orientation_landscape ? 'Landscape' : 'Portrait';

        return $options;
    }

}
