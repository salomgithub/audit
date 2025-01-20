<?php

namespace app\models;

use app\models\data\Branches;
use Yii;

/**
 * This is the model class for table "kunlik".
 *
 * @property int $id
 * @property int $user_id
 * @property int $branch
 * @property string $tek_mazmun
 * @property string $kamchilik
 * @property int|null $soni
 * @property int|null $summa
 * @property string|null $date_start
 * @property string|null $create_at
 *
 * @property Branches $branch0
 */
class Kunlik extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kunlik';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'user_id', 'branch', 'tek_mazmun', 'kamchilik'], 'required'],
            [['id', 'user_id', 'soni', 'summa'], 'integer'],
            [['tek_mazmun', 'kamchilik'], 'string'],
            [['date_start', 'create_at'], 'safe'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'FIO',
            'branch' => 'Qayerda',
            'tek_mazmun' => 'Tekshirishning qisqacha mazmuni',
            'kamchilik' => 'Aniqlangan holatning qisqchacha mazmuni',
            'soni' => 'Soni',
            'summa' => 'Summa',
            'date_start' => 'Tekshirish boshlangan sana',
            'create_at' => 'Create At',
        ];
    }

    /**
     * Gets query for [[Branch0]].
     *
     * @return \yii\db\ActiveQuery
     */

}
