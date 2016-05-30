<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "attachment".
 *
 * @property integer $id
 * @property string  $model_name
 * @property integer $model_id
 * @property string  $filename
 */
class Attachment extends ActiveRecord
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
                $this->model_name = $this->related_model->formName();
                $this->model_id = $this->related_model->id;
                list($this->filename, $this->filesize) = $this->saveUploaded($this->attach);
            } elseif (is_string($this->attach)) {
                //TODO
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

    public function getUrl()
    {
        $alias = $this->getPath(true);
        $alias = str_replace('@webroot', '@web', $alias);
        
        return Url::to($alias);
    }

    public function getPath($alias = false, $only_dir = false)
    {
        $subdir = '';
        if ($this->model_name) {
            $subdir .= $this->model_name . '/';
        }
        if ($this->model_id) {
            $subdir .= $this->model_id . '/';
        }

        $path = Yii::$app->params['dirs']['file_stored'] . $subdir;
        if (!$only_dir) {
            $path .= $this->filename;
        }

        return $alias ? $path : Yii::getAlias($path);
    }

    protected function saveUploaded(UploadedFile $file)
    {
        $dir = $this->getPath(false, true);

        $file_name = $file->getBaseName();
        $file_ext = $file->getExtension();

        $filename = $file_name .'.'. $file_ext;
        $index = 0;
        while (file_exists($dir . $filename)) {
            $index ++;
            $filename = $file_name . '-' . $index . '.' . $file_ext;
        }
        
        FileHelper::createDirectory($dir, 0777, true);
        $path = $dir . $filename;
        if ($file->saveAs($path)) {
            return [$filename, filesize($path)];
        }

        return false;
    }

}
