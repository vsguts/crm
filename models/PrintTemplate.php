<?php

namespace app\models;

use app\models\behaviors\MailingListBehavior;
use app\models\behaviors\TimestampBehavior;
use app\models\components\LookupTrait;
use app\models\query\PrintTemplateQuery;
use yii\helpers\Html;

/**
 * This is the model class for table "print_template".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property string $format
 * @property integer $orientation_landscape
 * @property integer $margin_top
 * @property integer $margin_bottom
 * @property integer $margin_left
 * @property integer $margin_right
 * @property integer $items_per_page
 * @property string $content
 * @property integer $wrapper_enabled
 * @property string $wrapper
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property PrintTemplateMailingList[] $printTemplateMailingLists
 * @property MailingList[] $lists
 *
 * @mixin MailingListBehavior
 */
class PrintTemplate extends AbstractModel
{
    use LookupTrait;

    public static function tableName()
    {
        return 'print_template';
    }

    public function behaviors()
    {
        return [
            MailingListBehavior::class,
            TimestampBehavior::class,
        ];
    }

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'format', 'content'], 'required'],
            [['content', 'wrapper'], 'string'],
            [['status', 'wrapper_enabled', 'orientation_landscape', 'margin_top', 'margin_bottom', 'margin_left', 'margin_right', 'items_per_page'], 'integer'],
            [['items_per_page'], 'default', 'value' => 0],
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
            'items_per_page' => __('Items per page'),
            'status' => __('Status'),
            'format' => __('Format'),
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrintTemplateMailingLists()
    {
        return $this->hasMany(PrintTemplateMailingList::class, ['template_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailingLists()
    {
        return $this
            ->hasMany(MailingList::class, ['id' => 'list_id'])
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
        $iteration = 0;
        $partners = Partner::find()->viaMailingLists($this->mailingLists)->all();

        if ($this->items_per_page) {
            $page_separator = Html::tag('div', '', ['style' => ['clear' => 'both']]);
            $page_begin_tag = Html::beginTag('div', ['style' => [
                'page-break-before' => 'always',
            ]]);
            $page_end_tag = $page_separator . Html::endTag('div');
            $content[] = $page_begin_tag;
        }
        foreach ($partners as $partner) {
            $iteration ++;
            $content[] = $this->processContent($this->content, $partner);
            if ($this->items_per_page && $iteration % $this->items_per_page == 0) {
                $content[] = $page_end_tag;
                $content[] = $page_begin_tag;
            }
        }
        if ($this->items_per_page) {
            $content[] = $page_end_tag;
        }

        $content = implode(PHP_EOL, $content);

        if ($this->wrapper_enabled) {
            $content = preg_replace('/\{content\}/Sui', $content, $this->wrapper);
        }

        return $content;
    }

    public function prepareOptions()
    {
        $options = [
            'page-size' => $this->format,
            'orientation' => $this->orientation_landscape ? 'Landscape' : 'Portrait',
        ];

        // Margins
        foreach (['top', 'bottom', 'left', 'right'] as $margin) {
            $field = 'margin_' . $margin;
            if (isset($this->$field)) {
                $options['margin-' . $margin] = $this->$field;
            }
        }

        return $options;
    }

}
