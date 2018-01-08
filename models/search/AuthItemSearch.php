<?php

namespace app\models\search;

use app\models\AuthItem;
use app\models\components\SearchTrait;
use yii\data\ActiveDataProvider;

/**
 * AuthItemSearch represents the model behind the search form about `common\models\AuthItem`.
 *
 * @property string $id
 * @property string $permission
 */
class AuthItemSearch extends AuthItem
{
    use SearchTrait;

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), [
            'id',
            // Range fields
            'permission',
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => __('ID'),
            'permission' => __('Permission'),
        ]);
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = AuthItem::find()->roles();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $this->getPaginationDefaults(),
            'sort' => [
                'defaultOrder' => [
                    'description' => SORT_ASC,
                ],
            ],
        ]);

        $params = $this->processParams($params);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'name' => $this->id,
            'type' => $this->type,
            'status' => $this->status,
            'rule_name' => $this->rule_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'data', $this->data])
        ;

        if ($this->permission) {
            $query->andWhere(['name' => self::findOne($this->permission)->getParentRolesRecursive()]);
        }

        return $dataProvider;
    }
}
