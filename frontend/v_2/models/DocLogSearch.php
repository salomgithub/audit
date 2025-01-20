<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DocLog;

/**
 * DocLogSearch represents the model behind the search form of `app\models\DocLog`.
 */
class DocLogSearch extends DocLog
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'work_id', 'user_id', 'status_old', 'status_new'], 'integer'],
            [['action', 'create_at', 'ip'], 'safe'],
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
        $query = DocLog::find();

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
            'work_id' => $this->work_id,
            'user_id' => $this->user_id,
            'status_old' => $this->status_old,
            'status_new' => $this->status_new,
            'create_at' => $this->create_at,
        ]);

        $query->andFilterWhere(['like', 'action', $this->action])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
