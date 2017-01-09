<?php

namespace app\models\search;

use app\behaviors\LookupBehavior;
use app\behaviors\SearchBehavior;
use app\behaviors\TagsBehavior;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Partner;

/**
 * PartnerSearch represents the model behind the search form about `app\models\Partner`.
 */
class PartnerSearch extends Partner
{
    
    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), [
            'q',
            'tag_id',
            'publicTagsStr',
            'personalTagsStr',
            'created_at_to',
            'updated_at_to',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                $this->attributes(),
                'safe'
            ],
            [
                ['name', 'email', 'state', 'address', 'notes', 'city', 'q'],
                'filter', 'filter' => 'trim'
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            SearchBehavior::class,
            TagsBehavior::class,
            LookupBehavior::class,
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Partner::find()
            ->permission()
            // ->joinWith('partnerTags')
            ->joinWith('tags')
            ->groupBy('partner.id')
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $this->getPaginationDefaults(),
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);
        
        $params = $this->processParams($params);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'partner.id' => $this->id,
            'type' => $this->type,
            'status' => $this->status,
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'parent_id' => $this->parent_id,
            'volunteer' => $this->volunteer,
            'candidate' => $this->candidate,
            'partner_tag.tag_id' => $this->tag_id,
        ]);

        $query
            ->andFilterWhere(['like', 'partner.name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        $tags = $this->parseTagsStr([$this->publicTagsStr, $this->personalTagsStr]);
        if (true) { // AND
            foreach ($tags as $tag) {
                $query->andFilterWhere(['tag.name' => $tag]);
            }
        } else { // OR
            $query->andFilterWhere(['in', 'tag.name', $tags]);
        }

        if ($this->q) {
            $query->orFilterWhere(['like', 'partner.name', $this->q]);
            $query->orFilterWhere(['like', 'email', $this->q]);
            $query->orFilterWhere(['like', 'notes', $this->q]);
        }
        
        $this->addRangeCondition($query, 'created_at');
        $this->addRangeCondition($query, 'updated_at');

        return $dataProvider;
    }
}
