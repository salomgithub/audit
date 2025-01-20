<?php

namespace app\models\search;

use app\models\AuthAssignment;
use app\models\data\Departaments;
use app\models\data\HeadMistakesGroup;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Work;
use yii\data\Pagination;

/**
 * WorkSearch represents the model behind the search form of `app\models\Work`.
 */
class WorkSearch extends Work
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

    public function search2($params)
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

        $departaments = Departaments::find()->all();
        $head_mistakes = HeadMistakesGroup::find()->all();
        $departamentsData = [];

        foreach ($departaments as $departament) {

            $departamentData = [
                'name' => $departament->name,
                'mistakes' => [],
            ];
            foreach ($head_mistakes as $head_mistake) {
//                $son = Work::find()
//                    ->where(['between', 'work_status', 0, 2])
//                    ->andWhere(['departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])
//                    ->andFilterWhere([
//                        'farmoyish_id' => $this->farmoyish_id,
//                        'region_id' => $this->region_id,
//                        'branch_id' => $this->branch_id,
//                        'year' => $this->year,
//                    ])
//                    ->sum('mistake_soni');
                $son = Work::find()
                    ->select(['SUM(mistake_soni)'])
                    ->where([
                        'departament_id' => $departament->id,
                        'head_mistakes_group_code' => $head_mistake->code,
                    ])
                    ->andWhere(['between', 'work_status', 0, 2])
                    ->andFilterWhere([
                        'farmoyish_id' => $this->farmoyish_id,
                        'region_id' => $this->region_id,
                        'branch_id' => $this->branch_id,
                        'year' => $this->year,
                    ])
                    ->scalar();
                if ($son > 0) {
//                    $sum = Work::find()
//                        ->andFilterWhere([
//                            'farmoyish_id' => $this->farmoyish_id,
//                            'region_id' => $this->region_id,
//                            'branch_id' => $this->branch_id,
//                            'year' => $this->year,
//                        ])
//                        ->where(['between', 'work_status', 0, 2])
//                        ->andWhere(['departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])
//                        ->sum('mistake_sum');


                    $sum = Work::find()
                        ->select(['SUM(mistake_sum)'])
                        ->where([
                            'departament_id' => $departament->id,
                            'head_mistakes_group_code' => $head_mistake->code,
                        ])
                        ->andWhere(['between', 'work_status', 0, 2])
                        ->andFilterWhere([
                            'farmoyish_id' => $this->farmoyish_id,
                            'region_id' => $this->region_id,
                            'branch_id' => $this->branch_id,
                            'year' => $this->year,
                        ])
                        ->scalar();

                    $bartaraf_son = Work::find()
                        ->where(['work_status' => 2, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])
                        ->andFilterWhere([
                            'farmoyish_id' => $this->farmoyish_id,
                            'region_id' => $this->region_id,
                            'branch_id' => $this->branch_id,
                            'year' => $this->year,
                        ])
                        ->sum('mistake_soni');

                    $bartaraf_sum = Work::find()
                        ->where(['work_status' => 2, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])
                        ->andFilterWhere([
                            'farmoyish_id' => $this->farmoyish_id,
                            'region_id' => $this->region_id,
                            'branch_id' => $this->branch_id,
                            'year' => $this->year,
                        ])
                        ->sum('mistake_sum');

                    $bartaraf_son = is_numeric($bartaraf_son) ? $bartaraf_son : 0;
                    $bartaraf_sum = is_numeric($bartaraf_sum) ? $bartaraf_sum : 0;

                } else {
                    $son = '-';
                    $sum = '-';
                    $bartaraf_son = '-';
                    $bartaraf_sum = '-';

                }
                $departamentData['mistakes'][] = [
                    'son' => $son,
                    'sum' => $sum,
                    'bartaraf_son' => $bartaraf_son,
                    'bartaraf_sum' => $bartaraf_sum,
                ];
            }
            $departamentsData[] = $departamentData;

        }


        return $departamentsData;
    }

    public function uzlashtirish($params)
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

        $departaments = Departaments::find()->all();
        $head_mistakes = HeadMistakesGroup::find()->all();
        $departamentsData = [];

        foreach ($departaments as $departament) {

            $departamentData = [
                'name' => $departament->name,
                'mistakes' => [],
            ];
            foreach ($head_mistakes as $head_mistake) {
                $son = Work::find()
                    ->where(['uzlashtirish' => 1, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])
                    ->andFilterWhere([
                        'farmoyish_id' => $this->farmoyish_id,
                        'region_id' => $this->region_id,
                        'branch_id' => $this->branch_id,
                        'year' => $this->year,
                    ])
                    ->sum('mistake_soni');
                if ($son > 0) {
                    $sum = Work::find()
                        ->where(['uzlashtirish' => 1, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])
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
                $departamentData['mistakes'][] = [
                    'son' => $son,
                    'sum' => $sum,
                ];
            }
            $departamentsData[] = $departamentData;

        }


        return $departamentsData;
    }

    public function akt($params)
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

        $departaments = Departaments::find()->all();
        $head_mistakes = HeadMistakesGroup::find()->all();
        $departamentsData = [];

        foreach ($departaments as $departament) {

            $departamentData = [
                'name' => $departament->name,
                'mistakes' => [],
            ];
            foreach ($head_mistakes as $head_mistake) {
                $son = Work::find()
                    ->where(['between', 'work_status', 0, 2])
                    ->andWhere(['departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])
                    ->andFilterWhere([
                        'farmoyish_id' => $this->farmoyish_id,
                        'region_id' => $this->region_id,
                        'year' => $this->year,
                    ])
                    ->sum('mistake_soni');
                if ($son > 0) {
                    $sum = Work::find()
                        ->andFilterWhere([
                            'farmoyish_id' => $this->farmoyish_id,
                            'region_id' => $this->region_id,
                            'year' => $this->year,
                        ])
                        ->where(['between', 'work_status', 0, 2])
                        ->andWhere(['departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])
                        ->sum('mistake_sum');

                    $bartaraf_son = Work::find()
                        ->where(['work_status' => 2, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])
                        ->andFilterWhere([
                            'farmoyish_id' => $this->farmoyish_id,
                            'region_id' => $this->region_id,
                            'year' => $this->year,
                        ])
                        ->sum('mistake_soni');

                    $bartaraf_sum = Work::find()
                        ->where(['work_status' => 2, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])
                        ->andFilterWhere([
                            'farmoyish_id' => $this->farmoyish_id,
                            'region_id' => $this->region_id,
                            'year' => $this->year,
                        ])
                        ->sum('mistake_sum');

                    $bartaraf_son = is_numeric($bartaraf_son) ? $bartaraf_son : 0;
                    $bartaraf_sum = is_numeric($bartaraf_sum) ? $bartaraf_sum : 0;

                } else {
                    $son = '-';
                    $sum = '-';
                    $bartaraf_son = '-';
                    $bartaraf_sum = '-';

                }
                $departamentData['mistakes'][] = [
                    'son' => $son,
                    'sum' => $sum,
                    'bartaraf_son' => $bartaraf_son,
                    'bartaraf_sum' => $bartaraf_sum,
                ];
            }
            $departamentsData[] = $departamentData;

        }


        return $departamentsData;
    }
}
