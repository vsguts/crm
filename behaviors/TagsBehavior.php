<?php

namespace app\behaviors;

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
            ActiveRecord::EVENT_AFTER_FIND    => 'eventGetTags',
            ActiveRecord::EVENT_AFTER_INSERT  => 'eventUpdateTags',
            ActiveRecord::EVENT_AFTER_UPDATE  => 'eventUpdateTags',
            ActiveRecord::EVENT_BEFORE_DELETE => 'eventRemoveTagsPre',
            ActiveRecord::EVENT_AFTER_DELETE  => 'eventRemoveTagsPost',
        ];
    }

    public function getPublicTagsParsed()
    {
        return 'gvs123';
    }

    public function eventGetTags($event)
    {
        $partner = $this->owner;

        foreach ($this->tagTypes as $type) {
            $partner_tags = $partner->$type;
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
                $key = $type . 'Str';
                if (isset($data[$key])) {
                    $tags = $this->parseTagsStr($data[$key]);
                    
                    $partner_tags = $partner->$type;
                    
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

}