<?php

namespace app\models\search;

use app\models\AuthAssignment;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Work;

/**
 * WorkSearch represents the model behind the search form of `app\models\Work`.
 */
class WorkSearch extends Work
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'farmoyish_id', 'region_id', 'branch_id', 'unical', 'head_mistakes_group_code', 'mistake_code', 'mistake_soni', 'work_status', 'user_id', 'departament_id'], 'integer'],
            [['year', 'client_name', 'mistak_from_user', 'comment'], 'safe'],
            [['mistake_sum'], 'number'],
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
        $query = Work::find();
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $role = AuthAssignment::findOne(['user_id' => $user_id]);
            $role = $role->item_name ? $role->item_name : 0;

            if ($role === 'auditor') {
                $query->andFilterWhere([
                    'user_id' => $user_id,
                ]);
            }
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pagesize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ]
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
            'farmoyish_id' => $this->farmoyish_id,
            'region_id' => $this->region_id,
            'branch_id' => $this->branch_id,
            'year' => $this->year,
            'unical' => $this->unical,
            'head_mistakes_group_code' => $this->head_mistakes_group_code,
            'mistake_code' => $this->mistake_code,
            'mistake_soni' => $this->mistake_soni,
            'mistake_sum' => $this->mistake_sum,
            'user_id' => $this->user_id,
            'departament_id' => $this->departament_id,
            'work_status' => $this->work_status,
        ]);

        $query->andFilterWhere(['like', 'client_name', $this->client_name])
            ->andFilterWhere(['like', 'mistak_from_user', $this->mistak_from_user])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
