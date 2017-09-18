<?php

namespace common\models\search;

use common\models\behaviors\TagsBehavior;
use common\models\components\SearchTrait;
use common\models\Partner;
use yii\data\ActiveDataProvider;

/**
 * PartnerSearch represents the model behind the search form about `common\models\Partner`.
 */
class PartnerSearch extends Partner
{
    use SearchTrait;

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), [
            'q',
            'tag_id',
            'publicTagsStr',
            'personalTagsStr',
            'email_existence',
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
    public function behaviors()
    {
        return [
            TagsBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'email_existence' => __('E-mail existence'),
        ]);
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
            'partner.type' => $this->type,
            'partner.status' => $this->status,
            'partner.country_id' => $this->country_id,
            'partner.state_id' => $this->state_id,
            'partner.parent_id' => $this->parent_id,
            'partner.volunteer' => $this->volunteer,
            'partner.candidate' => $this->candidate,
            'partner.communication_method' => $this->communication_method,
            'partner_tag.tag_id' => $this->tag_id,
        ]);

        $query
            ->andFilterWhere(['like', 'partner.name', $this->name])
            ->andFilterWhere(['like', 'partner.email', $this->email])
            ->andFilterWhere(['like', 'partner.state', $this->state])
            ->andFilterWhere(['like', 'partner.address', $this->address])
            ->andFilterWhere(['like', 'partner.city', $this->city])
            ->andFilterWhere(['like', 'partner.notes', $this->notes]);

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

        $this->addExistsCondition($query, 'email', $this->email_existence);

        $this->addRangeCondition($query, 'created_at');
        $this->addRangeCondition($query, 'updated_at');

        return $dataProvider;
    }
}
