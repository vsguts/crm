<?php

namespace common\models\search;

use common\models\components\SearchTrait;
use common\models\Tag;
use yii\data\ActiveDataProvider;

/**
 * TagSearch represents the model behind the search form about `common\models\Tag`.
 */
class TagSearch extends Tag
{
    use SearchTrait;

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Tag::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $this->getPaginationDefaults(),
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'tag.id' => $this->id,
            'tag.user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'tag.name', $this->name]);

        return $dataProvider;
    }
}
