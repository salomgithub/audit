<?php

namespace app\models\search;

use app\models\AuthAssignment;
use frontend\models\Worklist;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * WorklistSearch represents the model behind the search form of `app\models\Worklist`.
 */
class WorklistSearch extends Worklist
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'work_id', 'status'], 'integer'],
            [['file', 'commet'], 'safe'],
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
        $user_id = Yii::$app->user->id;
        $dep_id = \common\models\User::findOne($user_id)->dep_id;
        $role = AuthAssignment::findOne(['user_id' => $user_id]);
        $role = $role->item_name;

        $query = Worklist::find();

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
        if ($role === 'Administrator') {
            $query->andFilterWhere([
                'id' => $this->id,
                'work_id' => $this->work_id,
                'status' => $this->status,
            ]);
        }else {
            $query->andFilterWhere([
                'id' => $this->id,
                'work_id' => $this->work_id,
                'status' => $this->status,
                'dep_id' => $dep_id,
            ]);
        }


        $query->andFilterWhere(['like', 'file', $this->file])
            ->andFilterWhere(['like', 'commet', $this->commet]);

        return $dataProvider;
    }
}
