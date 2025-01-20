<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balance".
 *
 * @property int $id
 * @property int $branch_id
 * @property string $hisob_raqam
 * @property string $hisob_raqam_nomi
 * @property float $kirim_aktiv
 * @property float $kirim_passiv
 * @property float $debet
 * @property float $kredit
 * @property float $chiqim_aktiv
 * @property float $chiqim_passiv
 * @property string $from_data
 * @property string $to_data
 */
class Balance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'balance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hisob_raqam', 'hisob_raqam_nomi', 'branch_id', 'from_data', 'to_data'], 'required'],
            [['hisob_raqam_nomi'], 'string'],
            [['branch_id','kirim_aktiv', 'kirim_passiv', 'debet', 'kredit', 'chiqim_aktiv', 'chiqim_passiv'], 'number'],
            [['from_data', 'to_data'], 'safe'],
            [['hisob_raqam'], 'string', 'max' => 6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'branch_id' => 'Filial',
            'hisob_raqam' => 'Hisob Raqam',
            'hisob_raqam_nomi' => 'Hisob Raqam Nomi',
            'kirim_aktiv' => 'Kirim Aktiv',
            'kirim_passiv' => 'Kirim Passiv',
            'debet' => 'Debet',
            'kredit' => 'Kredit',
            'chiqim_aktiv' => 'Chiqim Aktiv',
            'chiqim_passiv' => 'Chiqim Passiv',
            'from_data' => 'From Data',
            'to_data' => 'To Data',
        ];
    }
}
