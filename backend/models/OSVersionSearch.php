<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OSVersion;

/**
 * OSVersionSearch represents the model behind the search form about `backend\models\OSVersion`.
 */
class OSVersionSearch extends OSVersion
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'osID'], 'integer'],
            [['version'], 'safe'],
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
        $query = OSVersion::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'osID' => $this->osID,
        ]);

        $query->andFilterWhere(['like', 'version', $this->version]);

        return $dataProvider;
    }
}
