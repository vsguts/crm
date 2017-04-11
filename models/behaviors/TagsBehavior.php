<?php

namespace app\models\behaviors;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\models\Tag;

class TagsBehavior extends Behavior
{

    const DELIMITER = ',';

    public $publicTagsStr;
    public $personalTagsStr;

    protected $tagTypes = ['publicTags', 'personalTags'];
    
    protected $tagsToGc = [];

    public function events()
    {
        return [
            // ActiveRecord::EVENT_AFTER_FIND    => 'prepareTags',
            ActiveRecord::EVENT_AFTER_INSERT  => 'eventUpdateTags',
            ActiveRecord::EVENT_AFTER_UPDATE  => 'eventUpdateTags',
            ActiveRecord::EVENT_BEFORE_DELETE => 'eventRemoveTagsPre',
            ActiveRecord::EVENT_AFTER_DELETE  => 'eventRemoveTagsPost',
        ];
    }

    public function attributeLabels()
    {
        return [
            'publicTags' => __('Public tags'),
            'personalTags' => __('Personal tags'),
        ];
    }

    public function prepareTags()
    {
        foreach ($this->tagTypes as $type) {
            $partner_tags = $this->getTagsByType($type);
            $key = $type . 'Str';
            
            $tags = [];
            foreach ($partner_tags as $mtag) {
                $tags[] = $mtag->name;
            }
            $this->$key = implode(static::DELIMITER, $tags);
        }
    }

    public function eventUpdateTags($event)
    {
        $partner = $this->owner;

        if ($data = Yii::$app->request->post($partner->formName())) { // FIXME
            foreach ($this->tagTypes as $type) {
                if ($type == 'publicTags' && !Yii::$app->user->can('public_tags_manage')) {
                    continue;
                }
                $key = $type . 'Str';
                if (isset($data[$key])) {
                    $tags = $this->parseTagsStr($data[$key]);

                    $partner_tags = $this->getTagsByType($type);

                    // Remove
                    foreach ($partner_tags as $partner_tag) {
                        if (!in_array($partner_tag->name, $tags)) {
                            $partner->unlink('tags', $partner_tag, true);
                            $partner_tag->gc();
                        }
                    }
                    
                    // Add existing
                    $mtags = Tag::find()->where(['name' => $tags])->$type()->all();
                    foreach ($mtags as $mtag) {
                        if (!in_array($mtag, $partner_tags)) {
                            $partner->link('tags', $mtag);
                        }
                        unset($tags[array_search($mtag->name, $tags)]);
                    }

                    // Add new
                    if ($type != 'publicTags' || Yii::$app->authManager->getUserObjects('public_tags') == 'all') {
                        foreach ($tags as $tag) {
                            $mtag = new Tag;
                            $mtag->name = $tag;
                            if ($type == 'personalTags') {
                                $mtag->setToPersonal();
                            }
                            $mtag->save();
                            $partner->link('tags', $mtag);
                        }
                    }
                }
            }
        }
    }

    public function eventRemoveTagsPre($event)
    {
        $this->tagsToGc = $this->owner->tags;
    }

    public function eventRemoveTagsPost($event)
    {
        foreach ($this->tagsToGc as $mtag) {
            $mtag->gc();
        }
    }

    public function parseTagsStr($str)
    {
        $tags = [];
        foreach ((array) $str as $s) {
            $_tags = explode(static::DELIMITER, $s);
            foreach ($_tags as &$tag) {
                $tags[] = trim($tag);
            }
        }
        return array_filter(array_unique($tags));
    }

    protected function getTagsByType($type)
    {
        $model = $this->owner;
        $method = 'get' . ucfirst($type);
        return $model->$method()->permission()->all();
    }

}
