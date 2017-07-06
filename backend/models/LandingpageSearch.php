<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Landingpage;

/**
 * LandingpageSearch represents the model behind the search form about `backend\models\Landingpage`.
 */
class LandingpageSearch extends Landingpage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'click', 'lead'], 'integer'],
            [['name', 'redirectUrl'], 'safe'],
            [['cost', 'income'], 'number'],
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
        $query = Landingpage::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'click' => $this->click,
            'cost' => $this->cost,
            'income' => $this->income,
            'lead' => $this->lead,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'redirectUrl', $this->redirectUrl]);

        return $dataProvider;
    }
}
