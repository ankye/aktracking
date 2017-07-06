<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Network;

/**
 * NetworkSearch represents the model behind the search form about `backend\models\Network`.
 */
class NetworkSearch extends Network
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'apikey', 'apiurl', 'website', 'systemType'], 'safe'],
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
        $query = Network::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'apikey', $this->apikey])
            ->andFilterWhere(['like', 'apiurl', $this->apiurl])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'systemType', $this->systemType]);

        return $dataProvider;
    }
}
