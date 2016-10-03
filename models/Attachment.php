<?php

namespace app\models;

use app\helpers\FileHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\base\Exception;
use yii\web\UploadedFile;

class Attachment extends AbstractModel
{
    public $related_model;
    public $attach;

    public static function tableName()
    {
        return 'attachment';
    }

    public function init()
    {
        parent::init();
        $this->on(ActiveRecord::EVENT_BEFORE_INSERT, [$this, 'attachEvent']);
        $this->on(ActiveRecord::EVENT_BEFORE_DELETE, [$this, 'detachEvent']);
    }

    public function attachEvent($event)
    {
        // Upload
        if ($this->attach) {
            if (is_a($this->attach, 'yii\web\UploadedFile')) {
                $this->table = $this->related_model->tableName();
                $this->object_id = $this->related_model->id;
                list($this->filename, $this->filesize) = $this->saveUploaded($this->attach);
            } elseif (is_string($this->attach)) {
                throw new Exception('TODO: Not implemented yet');
            }
        }

        if (!$this->filename) {
            $event->isValid = false;

            return false;
        }
    }

    public function detachEvent($event)
    {
        $file = $this->getPath();
        if (file_exists($file)) {
            unlink($file);
        }
    }

    public function getPath($alias = false, $only_dir = false)
    {
        $subdir = '';
        if ($this->table) {
            $subdir .= $this->table . '/';
        }
        if ($this->object_id) {
            $subdir .= $this->object_id . '/';
        }

        $path = Yii::$app->params['dirs']['file_stored'] . $subdir;
        if (!$only_dir) {
            $path .= $this->filename;
        }

        return $alias ? $path : Yii::getAlias($path);
    }

    public function getObject()
    {
        $class_name = 'app\models\\' . $this->table;
        if (class_exists($class_name)) {
            return $this->hasOne($class_name, ['id' => 'object_id']);
        }
    }

    protected function saveUploaded(UploadedFile $file)
    {
        $dir = $this->getPath(false, true);

        $file_name = $file->getBaseName();
        $file_ext = $file->getExtension();

        $filename = $file_name . '.' . $file_ext;
        $index = 0;
        while (file_exists($dir . $filename)) {
            $index++;
            $filename = $file_name . '-' . $index . '.' . $file_ext;
        }

        FileHelper::createDirectory($dir, 0777, true);
        $path = $dir . $filename;
        if ($file->saveAs($path)) {
            return [$filename, filesize($path)];
        }

        return false;;
    }

    /**
     * Check if file can be displayed in browser
     * @return array
     */
    public function canShow()
    {
        return FileHelper::canShow($this->getPath());
    }

}
