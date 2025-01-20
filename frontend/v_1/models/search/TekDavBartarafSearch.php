<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TekDavBartaraf;

/**
 * TekDavBartarafSearch represents the model behind the search form of `app\models\TekDavBartaraf`.
 */
class TekDavBartarafSearch extends TekDavBartaraf
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'farmoish_id', 'region_id', 'branch_id', 'mistake_id', 'bartaraf_son', 'bartaraf_sum'], 'integer'],
            [['file'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = TekDavBartaraf::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'farmoish_id' => $this->farmoish_id,
            'region_id' => $this->region_id,
            'branch_id' => $this->branch_id,
            'mistake_id' => $this->mistake_id,
            'bartaraf_son' => $this->bartaraf_son,
            'bartaraf_sum' => $this->bartaraf_sum,
        ]);

        $query->andFilterWhere(['like', 'file', $this->file]);

        return $dataProvider;
    }
}
