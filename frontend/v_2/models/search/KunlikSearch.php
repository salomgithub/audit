<?php

namespace app\models\search;

use app\models\AuthAssignment;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kunlik;

/**
 * KunlikSearch represents the model behind the search form of `app\models\Kunlik`.
 */
class KunlikSearch extends Kunlik
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id',  'soni', 'summa'], 'integer'],
            [['tek_mazmun', 'kamchilik', 'branch', 'date_start', 'create_at'], 'safe'],
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
        $query = Kunlik::find();

        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $role = AuthAssignment::findOne(['user_id' => $user_id]);
            $role = $role->item_name?$role->item_name:0;

            if ($role === 'auditor') {
                $query->andFilterWhere([
                    'user_id' => $user_id,
                ]);
            }
        }

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
            'user_id' => $this->user_id,
            'soni' => $this->soni,
            'summa' => $this->summa,
            'date_start' => $this->date_start,
            'create_at' => $this->create_at,
        ]);

        $query->andFilterWhere(['like', 'tek_mazmun', $this->tek_mazmun])
            ->andFilterWhere(['like', 'branch', $this->branch])
            ->andFilterWhere(['like', 'kamchilik', $this->kamchilik]);

        return $dataProvider;
    }
}
