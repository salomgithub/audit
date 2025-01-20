<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Davomat;

/**
 * DavomatSearch represents the model behind the search form of `app\models\Davomat`.
 */
class DavomatSearch extends Davomat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employee_id', 'action', 'sabab'], 'integer'],
            [['photo', 'time'], 'safe'],
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
        $query = Davomat::find();

        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $role = AuthAssignment::findOne(['user_id' => $user_id]);
            $role = $role->item_name ? $role->item_name : 0;

            if ($role === 'auditor') {
                $query->andFilterWhere([
                    'employee_id' => $user_id,
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
            'employee_id' => $this->employee_id,
            'action' => $this->action,
            'sabab' => $this->sabab,
        ]);
        $query->andFilterWhere(['like', 'photo', $this->photo]);
        $query->andFilterWhere(['like', 'time', $this->time]);

        return $dataProvider;
    }
}
