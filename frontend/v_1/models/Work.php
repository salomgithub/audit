<?php

namespace app\models;

use app\models\data\Branches;
use app\models\data\Departaments;
use app\models\data\HeadMistakesGroup;
use app\models\data\Mistakes;
use app\models\data\Orders;
use app\models\data\Regions;
use frontend\models\SignupForm;
use mdm\admin\models\User;
use Yii;

/**
 * This is the model class for table "work".
 *
 * @property int $id
 * @property int $farmoyish_id
 * @property int $region_id
 * @property int $branch_id
 * @property string $year
 * @property int $unical кредитдан ташқари ҳолларда уникалка
 * @property int $hisob_raqam hisob raqam
 * @property string $client_name
 * @property int $head_mistakes_group_code
 * @property int $mistake_code
 * @property int $mistake_soni
 * @property float $mistake_sum
 * @property string $mistak_from_user xato qilgan xodim
 * @property int $user_id tekshiruvchi
 * @property int $departament_id kamchilik bartaraf qiladigan departament
 * @property string|null $comment
 *
 * @property Branches $branch
 * @property Departaments $departament
 * @property Orders $farmoyish
 * @property HeadMistakesGroup $headMistakesGroupCode
 * @property Mistakes $mistakeCode
 * @property Regions $region
 * @property Regions $work_status
 */
class Work extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'work';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['farmoyish_id', 'region_id', 'branch_id', 'year',  'client_name', 'head_mistakes_group_code', 'mistake_code', 'status', 'mistake_soni','bartaraf_soni', 'mistak_from_user', 'departament_id'], 'required'],
            [['farmoyish_id', 'region_id', 'branch_id', 'unical', 'head_mistakes_group_code', 'mistake_code', 'mistake_soni','bartaraf_soni', 'user_id','bartaraf_sum', 'departament_id'], 'integer'],
            [['year', 'work_status'], 'safe'],
            [['mistake_sum','unical','hisob_raqam'], 'number'],
            [['client_name'], 'string', 'max' => 100],
            [['mistak_from_user', 'comment'], 'string', 'max' => 255],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::class, 'targetAttribute' => ['region_id' => 'id']],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branches::class, 'targetAttribute' => ['branch_id' => 'id']],
            [['departament_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departaments::class, 'targetAttribute' => ['departament_id' => 'id']],
            [['mistake_code'], 'exist', 'skipOnError' => true, 'targetClass' => Mistakes::class, 'targetAttribute' => ['mistake_code' => 'code']],
            [['farmoyish_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['farmoyish_id' => 'code']],
            [['head_mistakes_group_code'], 'exist', 'skipOnError' => true, 'targetClass' => HeadMistakesGroup::class, 'targetAttribute' => ['head_mistakes_group_code' => 'code']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'farmoyish_id' => 'Farmoyish ID',
            'region_id' => 'Viloyat',
            'branch_id' => 'Filial',
            'year' => 'Tekshirilgan yil',
            'unical' => 'Kredit ID',
            'client_name' => 'Mijoz FIO',
            'head_mistakes_group_code' => 'Bo`linma nomi',
            'mistake_code' => 'Kamchilik nomi',
            'status' => 'holati',
            'mistake_soni' => 'Kamchilik soni',
            'mistake_sum' => 'Kamchilik summasi',
            'bartaraf_soni' => 'Bartaraf soni',
            'bartaraf_sum' => 'Bartaraf summasi',
            'mistak_from_user' => 'Kamchilik sababchisi FIO',
            'user_id' => 'Kamchilik aniqlagan hodim',
            'departament_id' => 'Departament ID',
            'comment' => 'izoh',
            'work_status' => 'Status',
        ];
    }

    /**
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branches::class, ['id' => 'branch_id']);
    }

    /**
     * Gets query for [[Departament]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDepartament()
    {
        return $this->hasOne(Departaments::class, ['id' => 'departament_id']);
    }


    /**
     * Gets query for [[Farmoyish]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFarmoyish()
    {
        return $this->hasOne(Orders::class, ['code' => 'farmoyish_id']);
    }

    /**
     * Gets query for [[HeadMistakesGroupCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHeadMistakesGroupCode()
    {
        return $this->hasOne(HeadMistakesGroup::class, ['code' => 'head_mistakes_group_code']);
    }

    /**
     * Gets query for [[MistakeCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMistakeCode()
    {
        return $this->hasOne(Mistakes::class, ['code' => 'mistake_code']);
    }

    /**
     * Gets query for [[Region]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(Regions::class, ['id' => 'region_id']);
    }
}
