<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Campaign;

/**
 * CampaignSearch represents the model behind the search form about `backend\models\Campaign`.
 */
class CampaignSearch extends Campaign
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sourceID', 'type', 'inactive','passParams'], 'integer'],
            [['name', 'pingback', 'slug', 'c1', 'c2', 'c3', 'c4', 'c5', 'c6', 'c7', 'c8', 'c9', 'c10', 'c11', 'c12', 'c13', 'c14', 'c15', 'c16'], 'safe'],
            [['bid'], 'number'],
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
        $query = Campaign::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sourceID' => $this->sourceID,
            'type' => $this->type,
            'bid' => $this->bid,
            'inactive' => $this->inactive,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'pingback', $this->pingback])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'c1', $this->c1])
            ->andFilterWhere(['like', 'c2', $this->c2])
            ->andFilterWhere(['like', 'c3', $this->c3])
            ->andFilterWhere(['like', 'c4', $this->c4])
            ->andFilterWhere(['like', 'c5', $this->c5])
            ->andFilterWhere(['like', 'c6', $this->c6])
            ->andFilterWhere(['like', 'c7', $this->c7])
            ->andFilterWhere(['like', 'c8', $this->c8])
            ->andFilterWhere(['like', 'c9', $this->c9])
            ->andFilterWhere(['like', 'c10', $this->c10])
            ->andFilterWhere(['like', 'c11', $this->c11])
            ->andFilterWhere(['like', 'c12', $this->c12])
            ->andFilterWhere(['like', 'c13', $this->c13])
            ->andFilterWhere(['like', 'c14', $this->c14])
            ->andFilterWhere(['like', 'c15', $this->c15])
            ->andFilterWhere(['like', 'c16', $this->c16]);

        return $dataProvider;
    }
}
