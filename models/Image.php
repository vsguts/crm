<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "image".
 *
 * @property integer $id
 * @property string $model_name
 * @property integer $model_id
 * @property string $filename
 */
class Image extends ActiveRecord
{
    const QUALITY = 75;

    public $related_model;
    public $attach;

    protected $_unset_defaults = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'image';
    }

    public function init()
    {
        parent::init();
        $this->on(ActiveRecord::EVENT_BEFORE_INSERT, [$this, 'attachImageEvent']);
        $this->on(ActiveRecord::EVENT_BEFORE_INSERT, [$this, 'updateDefaultsEvent']);
        $this->on(ActiveRecord::EVENT_BEFORE_UPDATE, [$this, 'updateDefaultsEvent']);
        $this->on(ActiveRecord::EVENT_AFTER_INSERT, [$this, 'updateDefaultsPostEvent']);
        $this->on(ActiveRecord::EVENT_AFTER_UPDATE, [$this, 'updateDefaultsPostEvent']);
        $this->on(ActiveRecord::EVENT_BEFORE_DELETE, [$this, 'detachImageEvent']);
    }

    public function attachImageEvent($event)
    {
        // Upload
        if ($this->attach) {
            if (is_a($this->attach, 'yii\web\UploadedFile')) {
                $this->model_name = $this->related_model->formName();
                $this->model_id = $this->related_model->id;
                $this->filename = $this->saveUploaded($this->attach);
            } elseif (is_string($this->attach)) {
                //TODO
            }
        }

        if (!$this->filename) {
            $event->isValid = false;
            return false;
        }
    }

    public function detachImageEvent($event)
    {
        // Cached
        $fileinfo = pathinfo($this->filename);
        $files_mask = $fileinfo['filename'] . '_*.' . $fileinfo['extension'];
        $cahce_dir = $this->getPath(true, false, true);
        $cache_files = FileHelper::findFiles($cahce_dir, ['only' => [$files_mask]]);
        foreach ($cache_files as $file) {
            if (file_exists($file)) {
                unlink($file);
            }
        }

        // Stored
        $file = $this->getPath();
        if (file_exists($file)) {
            unlink($file);
        }
    }

    public function updateDefaultsEvent($event)
    {
        $default_images = static::find()
            ->where([
                'model_name' => $this->model_name,
                'model_id' => $this->model_id,
                'default' => 1,
            ])
            ->all();

        if ($this->default) {

            foreach ($default_images as $image) {
                $this->_unset_defaults[] = $image;
            }

        } else {

            foreach ($default_images as $k => $image) {
                if (!$this->isNewRecord && $image->id == $this->id) { // exclude itself
                    unset($default_images[$k]);
                }
            }
            if (!$default_images) {
                $this->default = 1;
            }

        }
    }

    public function updateDefaultsPostEvent($event)
    {
        foreach ($this->_unset_defaults as $self) {
            $self->default = null;
            $self->save();
        }
    }

    public function getUrl($size = '')
    {
        $alias = $this->getPath($size, true);
        $alias = str_replace('@webroot', '@web', $alias);
        
        return Url::to($alias);
    }

    public function getPath($size = '', $alias = false, $only_dir = false)
    {
        $subdir = '';
        if ($this->model_name) {
            $subdir .= $this->model_name . '/';
        }
        if ($this->model_id) {
            $subdir .= $this->model_id . '/';
        }

        $path = Yii::$app->params['dirs']['images_store'] . $subdir;
        if (!$only_dir) {
            $path .= $this->filename;
        }

        if ($size) {
            $path = Yii::$app->params['dirs']['images_cache'] . $subdir;
            if (!$only_dir) {
                $file = pathinfo($this->filename);
                $path .= $file['filename'] . '_' . $size . '.' . $file['extension'];

                $real_path = Yii::getAlias($path);
                if (!file_exists($real_path)) {
                    $this->generate($real_path, $size);
                }
            }
        }
        
        return $alias ? $path : Yii::getAlias($path);
    }

    protected function generate($filename, $size)
    {
        $sizes = explode('x', $size, 2);

        $sizes = [
            'w' => $sizes[0] ?: null,
            'h' => !empty($sizes[1]) ? $sizes[1] : null,
        ];

        $this->createFileDir($filename);

        $image = Yii::$app->image->load($this->getPath());
        $image->resize($sizes['w'], $sizes['h']);
        $image->save($filename, static::QUALITY);
    }

    protected function saveUploaded(UploadedFile $image)
    {
        $dir = $this->getPath(false, false, true);

        $image_name = $image->getBaseName();
        $image_ext = $image->getExtension();

        $filename = $image_name .'.'. $image_ext;
        $index = 0;
        while (file_exists($dir . $filename)) {
            $index ++;
            $filename = $image_name . '-' . $index . '.' . $image_ext;
        }
        
        $path = $dir . $filename;
        $this->createFileDir($path);
        if ($image->saveAs($path)) {
            return $filename;
        }

        return false;
    }

    protected function createFileDir($path)
    {
        $dir = dirname($path);
        return FileHelper::createDirectory($dir, 0777, true);
    }

}
