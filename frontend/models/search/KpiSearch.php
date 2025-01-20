<?php

namespace app\models\search;

use app\models\AuthAssignment;
use app\models\Kpi;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Work;


class KpiSearch extends Work
{
    public $start_data;
    public $end_data;
    public $perPage;

    public function rules()
    {
        return [
            [['id', 'farmoyish_id', 'region_id', 'branch_id', 'unical', 'head_mistakes_group_code', 'mistake_code', 'mistake_soni', 'work_status', 'user_id', 'departament_id'], 'integer'],
            [['year', 'client_name', 'start_data', 'end_data', 'mistak_from_user', 'comment'], 'safe'],
            [['mistake_sum', 'perPage'], 'number'],

        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

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
        $start = empty($this->start_data) ? date('Y-m-d', strtotime('-1 month', strtotime(date('Y-m-d')))) : $this->start_data . " 00:00:01";

        $end = $this->end_data . " 23:59:59";
        $query->andFilterWhere(['like', 'client_name', $this->client_name])
            ->andFilterWhere(['like', 'mistak_from_user', $this->mistak_from_user])
            ->andFilterWhere(['between', 'create_at', $start, $end])
            ->andFilterWhere(['like', 'comment', $this->comment]);
        if ($this->perPage == "" || $this->perPage == NULL || $this->perPage > 200) $this->perPage = 20;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->perPage,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);

        return $dataProvider;
    }

    public function kpi($params)
    {
        $query = Work::find();

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'year' => $this->year,
            'user_id' => $this->user_id,
            'work_status' => $this->work_status,
        ]);

        $query->andFilterWhere(['like', 'client_name', $this->client_name])
            ->andFilterWhere(['like', 'mistak_from_user', $this->mistak_from_user])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        $users = User::find()->all();
        $kpi = Kpi::find()->all();


        $usersData = [];

        foreach ($users as $user) {

            $userData = [
                'name' => $user->fio,
                'mistakes' => [],
            ];
            foreach ($kpi as $kpiItem) {
                $son = Work::find()
                    ->where(['uzlashtirish' => $kpiItem->id, 'user_id' => $user->id])
                    ->andFilterWhere([
                        'farmoyish_id' => $this->farmoyish_id,
                        'region_id' => $this->region_id,
                        'branch_id' => $this->branch_id,
                        'year' => $this->year,
                    ])
                    ->sum('mistake_soni');
                if ($son > 0) {
                    $sum = Work::find()
                        ->where(['uzlashtirish' => $kpiItem->id, 'user_id' => $user->id])
                        ->andFilterWhere([
                            'farmoyish_id' => $this->farmoyish_id,
                            'region_id' => $this->region_id,
                            'year' => $this->year,
                        ])
                        ->sum('mistake_sum');
                } else {
                    $son = '-';
                    $sum = '-';
                    $bartaraf_son = '-';
                    $bartaraf_sum = '-';

                }
                $userData['mistakes'][] = [
                    'son' => $son,
                    'sum' => $sum,
                ];
            }
            $usersData[] = $userData;

        }
        return $usersData;
    }


}
