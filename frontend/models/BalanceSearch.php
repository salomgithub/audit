<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Balance;

/**
 * BalanceSearch represents the model behind the search form of `app\models\Balance`.
 */
class BalanceSearch extends Balance
{
    public $branch_id;
    public $region_id;
    public function rules()
    {
        return [
            [['id', 'kirim_passiv', 'debet', 'kredit', 'chiqim_aktiv', 'chiqim_passiv'], 'integer'],
            [['hisob_raqam', 'hisob_raqam_nomi', 'kirim_aktiv', 'from_data', 'to_data'], 'safe'],
        ];
    }
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Balance::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'kirim_passiv' => $this->kirim_passiv,
            'debet' => $this->debet,
            'kredit' => $this->kredit,
            'chiqim_aktiv' => $this->chiqim_aktiv,
            'chiqim_passiv' => $this->chiqim_passiv,
            'from_data' => $this->from_data,
            'to_data' => $this->to_data,
        ]);

        $query->andFilterWhere(['like', 'hisob_raqam', $this->hisob_raqam])
            ->andFilterWhere(['like', 'hisob_raqam_nomi', $this->hisob_raqam_nomi])
            ->andFilterWhere(['like', 'kirim_aktiv', $this->kirim_aktiv]);

        return $dataProvider;
    }
}
