<?php

namespace app\models\behaviors;

use Yii;
use yii\base\Behavior;
use yii\helpers\FileHelper;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use app\models\Attachment;

/**
 * Multiple Attachments which stored in separate table 'attachnemt'
 */
class AttachmentsBehavior extends Behavior
{
    const DEFAULT_OBJECT_TYPE = 'main';

    public $attachmentsUpload = []; // upload
    public $attachments = []; // just view

    /**
     * Settings
     */

    public $objectTypes = [self::DEFAULT_OBJECT_TYPE];

    public $hasAttachmentsSchema = [
        self::DEFAULT_OBJECT_TYPE => 'has_attachments',
    ];


    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT  => 'attachAttachments',
            ActiveRecord::EVENT_AFTER_UPDATE  => 'attachAttachments',
            ActiveRecord::EVENT_BEFORE_DELETE => 'removeAttachments',
        ];
    }

    public function rules()
    {
        return [
            ['attachmentsUpload', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'attachmentsUpload' => __('Upload attachments'),
            'attachments' => __('Attachments'),
        ];
    }

    public function attachAttachments($event)
    {
        $model = $this->owner;
        
        foreach ($this->objectTypes as $object_type) {
            $files = UploadedFile::getInstances($model, 'attachmentsUpload[' . $object_type . ']');
            if ($files) {
                foreach ($files as $file) {
                    $file_model = new Attachment;
                    $file_model->attach = $file;
                    $file_model->related_model = $model;
                    $file_model->table = $model->tableName();
                    $file_model->object_id = $model->id;
                    $file_model->object_type = $object_type;
                    $file_model->save();
                }
            }
        }

        $this->updateHasAttachmentsFlags();
    }

    public function removeAttachments($event)
    {
        $model = $this->owner;

        $dir = false;
        foreach ($model->getAllAttachments() as $file) {
            if (!$dir) {
                $dir = $file->getPath(false, true);
            }
            $file->delete();
        }
        if ($dir) {
            FileHelper::removeDirectory($dir);
        }
    }

    public function getAttachments($object_type = self::DEFAULT_OBJECT_TYPE)
    {
        if ($this->owner->isNewRecord) {
            return [];
        }

        return Attachment::find()
            ->where([
                'table' => $this->owner->tableName(),
                'object_id' => $this->owner->id,
                'object_type' => $object_type,
            ])
            ->orderBy(['id' => SORT_ASC])
            ->all();
    }

    public function getAllAttachments()
    {
        if ($this->owner->isNewRecord) {
            return [];
        }

        return Attachment::find()
            ->where([
                'table' => $this->owner->tableName(),
                'object_id' => $this->owner->id,
            ])
            ->orderBy(['id' => SORT_ASC])
            ->all();
    }

    public function updateHasAttachmentsFlags($object_type = self::DEFAULT_OBJECT_TYPE)
    {
        $model = $this->owner;
        $attributes = $model->attributes();
        
        foreach ($this->hasAttachmentsSchema as $object_type => $field) {
            if (in_array($field, $attributes)) {
                $attachemts = $this->getAttachments($object_type);
                $model->$field = !empty($attachemts) ? 1 : 0;
                if ($model->$field != $model->getOldAttribute($field)) {
                    Yii::$app->db->createCommand()->update(
                        $model->tableName(),
                        [$field => $model->$field],
                        ['id' => $model->id]
                    )->execute();
                    $model->setOldAttribute($field, $model->$field);
                }
            }
        }
    }

}
