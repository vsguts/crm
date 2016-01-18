<?php

namespace app\behaviors;

use yii\base\Behavior;
use yii\helpers\FileHelper;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use app\models\Attachment;

class AttachmentsBehavior extends Behavior
{
    public $attachmentsUpload = []; // upload
    public $attachments = []; // udpate

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT  => 'attachAttachments',
            ActiveRecord::EVENT_AFTER_UPDATE  => 'updateAttachments',
            ActiveRecord::EVENT_BEFORE_DELETE => 'removeAttachments',
        ];
    }

    public function rules()
    {
        return [
            ['attachmentsUpload', 'file'],
            ['attachments', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'attachmentsUpload' => __('Upload attachment'),
            'attachments' => __('Attachments'),
        ];
    }

    public function attachAttachments($event)
    {
        $model = $event->sender;
        
        $files = UploadedFile::getInstances($model, 'attachmentsUpload');
        foreach ($files as $file) {
            $file_model = new Attachment;
            $file_model->attach = $file;
            $file_model->related_model = $this->owner;
            $file_model->model_name = $this->owner->formName();
            $file_model->model_id = $this->owner->id;
            $file_model->save();
        }
    }

    public function updateAttachments($event)
    {
        foreach ($this->owner->attachments as $id => $params) {
            if (!empty($params['delete'])) {
                $file = Attachment::findOne($id);
                $file->delete();
            }
        }

        $this->attachAttachments($event);
    }

    public function removeAttachments($event = false)
    {
        if ($event) {
            $model = $event->sender;
        } else {
            $model = $this->owner;
        }

        $dir = false;
        foreach ($model->getAttachments() as $file) {
            if (!$dir) {
                $dir = $file->getPath(false, true);
            }
            $file->delete();
        }
        if ($dir) {
            FileHelper::removeDirectory($dir);
        }
    }

    public function getAttachments()
    {
        return Attachment::find()
            ->where([
                'model_name' => $this->owner->formName(),
                'model_id'   => $this->owner->id,
            ])
            ->orderBy(['id' => SORT_ASC])
            ->all();
    }

}
