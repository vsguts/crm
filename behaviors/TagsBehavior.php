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
            ActiveRecord::EVENT_AFTER_FIND => 'getTags',
            ActiveRecord::EVENT_AFTER_INSERT => 'updateTags',
            ActiveRecord::EVENT_AFTER_UPDATE => 'updateTags',
            ActiveRecord::EVENT_BEFORE_DELETE => 'removeTagsPre',
            ActiveRecord::EVENT_AFTER_DELETE => 'removeTagsPost',
        ];
    }

    public function getTags($event)
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

    public function updateTags($event)
    {
        $partner = $this->owner;

        if ($data = Yii::$app->request->post($partner->formName())) { // FIXME
            foreach ($this->tagTypes as $type) {
                $key = $type . 'Str';
                if (isset($data[$key])) {
                    $tags = $this->parseStr($data[$key]);
                    
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

    public function removeTagsPre($event)
    {
        $this->tagsToGc = $this->owner->tags;
    }

    public function removeTagsPost($event)
    {
        foreach ($this->tagsToGc as $mtag) {
            $mtag->gc();
        }
    }

    protected function parseStr($str)
    {
        $tags = explode(static::DELIMITER, $str);
        foreach ($tags as &$tag) {
            $tag = trim($tag);
        }
        return array_filter(array_unique($tags));
    }

}