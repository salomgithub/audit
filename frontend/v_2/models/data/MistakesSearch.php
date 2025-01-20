<?php

namespace app\models\data;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\data\Mistakes;

/**
 * MistakesSearch represents the model behind the search form of `app\models\data\Mistakes`.
 */
class MistakesSearch extends Mistakes
{
    /**
     * @var mixed|null
     */


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code','uzlashtirish', 'quantity', 'status', 'head_mistakes_group_code', 'mistakes_group_code'], 'integer'],
            [['name', 'create_at'], 'safe'],
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
        $query = Mistakes::find();

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
            'code' => $this->code,
            'uzlashtirish'=> $this->uzlashtirish,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'create_at' => $this->create_at,
            'head_mistakes_group_code' => $this->head_mistakes_group_code,
            'mistakes_group_code' => $this->mistakes_group_code,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
