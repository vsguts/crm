<?php

namespace app\models\search;

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
            'tag_id',
            'publicTagsStr',
            'personalTagsStr',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'id', 'type', 'status', 'country_id', 'state_id', 'city', 'church_id', 'volunteer', 'candidate', 'created_at', 'updated_at',
                    'tag_id'
                ],
                'integer'
            ], [
                [
                    'name', 'firstname', 'lastname', 'email', 'state', 'address', 'notes',
                    'tag_id', 'publicTagsStr', 'personalTagsStr'
                ],
                'safe'
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Partner::find()
            // ->joinWith('partnerTags')
            ->joinWith('tags')
            ->groupBy('partner.id')
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        
        $query->andFilterWhere([
            'partner.id' => $this->id,
            'type' => $this->type,
            'status' => $this->status,
            'country_id' => $this->country_id,
            'state_id' => $this->state_id,
            'city' => $this->city,
            'church_id' => $this->church_id,
            'volunteer' => $this->volunteer,
            'candidate' => $this->candidate,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'partner_tag.tag_id' => $this->tag_id,
        ]);

        $query
            ->andFilterWhere(['like', 'partner.name', $this->name])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        $tags = $this->parseTagsStr([$this->publicTagsStr, $this->personalTagsStr]);
        if (true) { // AND
            foreach ($tags as $tag) {
                $query->andFilterWhere(['tag.name' => $tag]);
            }
        } else { // OR
            $query->andFilterWhere(['in', 'tag.name', $tags]);
        }
        // pd($query);

        return $dataProvider;
    }
}
