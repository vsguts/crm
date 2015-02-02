<?php

namespace app\models;

use Yii;
use app\models\query\PrintTemplateQuery;

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
 * @property string $content
 * @property string $wrapper
 * @property integer $wrapper_enabled
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class PrintTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'print_template';
    }

    public function behaviors()
    {
        return [
            'yii\behaviors\TimestampBehavior',
            'app\behaviors\LookupBehavior',
            'app\behaviors\ListBehavior',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'format', 'content'], 'required'],
            [['content', 'wrapper'], 'string'],
            [['status', 'format', 'wrapper_enabled', 'orientation_landscape', 'margin_top', 'margin_bottom', 'margin_left', 'margin_right'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'content' => Yii::t('app', 'Content'),
            'wrapper' => __('Wrapper'),
            'wrapper_enabled' => __('Enable wrapper'),
            'orientation_landscape' => __('Landscape orientation'),
            'margin_top' => __('Margin top'),
            'margin_bottom' => __('Margin bottom'),
            'margin_left' => __('Margin left'),
            'margin_right' => __('Margin right'),
            'status' => __('Status'),
            'format' => __('Format'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    public function init()
    {
        parent::init();
        
        // Default values
        $this->wrapper = '{content}';
        $this->margin_top = 16;
        $this->margin_bottom = 16;
        $this->margin_left = 15;
        $this->margin_right = 15;
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
     * Lookup
     */
    public function getStatusName()
    {
        return $this->getLookupItem('status', $this->status);
    }

    public function getFormatName()
    {
        return $this->getLookupItem('format', $this->format);
    }

    /**
     * Print
     */
    public function findRelatedObjects($ids)
    {
        return Partner::find()->where(['id' => $ids])->all();
    }

    public function prepareContent($model)
    {
        $content = $this->content;

        $content = preg_replace_callback('/\{([a-z.0-9]+)\}/Sui', function($m) use($model) {
            $parts = explode('.', $m[1]);
            $result = $model;
            foreach ($parts as $part) {
                if (is_object($result) && isset($result->$part)) {
                    $result = $result->$part;
                }
            }

            if (is_object($result)) {
                return $m[0];
            }
            return $result;
        }, $content);

        if ($this->wrapper_enabled) {
            $content = preg_replace('/\{content\}/Sui', $content, $this->wrapper);
        }

        return $content;
    }

    public function prepareOptions()
    {
        $options = [];
        
        $options['format'] = $this->getLookupItem('format', $this->format);
        
        // Margins
        foreach (['top', 'bottom', 'left', 'right'] as $margin) {
            $field = 'margin_' . $margin;
            if (isset($this->$field)) {
                $options['margin' . ucfirst($margin)] = $this->$field;
            }
        }

        // Orientation
        if ($this->orientation_landscape) {
            $options['format'] .= '-L';
        }

        return $options;
    }

}
