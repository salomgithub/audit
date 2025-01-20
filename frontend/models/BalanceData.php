<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balance_data".
 *
 * @property int $id
 * @property string $data_from
 * @property string $data_to
 */
class BalanceData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'balance_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data_from', 'data_to'], 'required'],
            [['data_from', 'data_to'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data_from' => 'Data From',
            'data_to' => 'Data To',
        ];
    }
}
