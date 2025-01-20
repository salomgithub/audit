<?php

namespace app\models;

use app\models\data\Branches;
use app\models\data\Departaments;
use app\models\data\Mistakes;
use app\models\data\Orders;
use app\models\data\Regions;
use Yii;

/**
 * This is the model class for table "tekdan_keyin_bartaraf".
 *
 * @property int $id
 * @property int $farmoyish_id
 * @property int $region_id
 * @property int $branch_id
 * @property int $mistake_id
 * @property string $file
 * @property int $departament_id
 * @property int $status
 *
 * @property Branches $branch
 * @property Departaments $departament
 * @property Orders $farmoyish
 * @property Mistakes $mistake
 * @property Regions $region
 */
class TekdanKeyinBartaraf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tekdan_keyin_bartaraf';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['farmoyish_id', 'region_id', 'branch_id', 'mistake_id', 'file', 'departament_id'], 'required'],
            [['farmoyish_id', 'region_id', 'branch_id', 'mistake_id', 'departament_id', 'status'], 'integer'],
            [['file'], 'string', 'max' => 100],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branches::class, 'targetAttribute' => ['branch_id' => 'id']],
            [['departament_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departaments::class, 'targetAttribute' => ['departament_id' => 'id']],
            [['farmoyish_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['farmoyish_id' => 'code']],
            [['mistake_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mistakes::class, 'targetAttribute' => ['mistake_id' => 'code']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::class, 'targetAttribute' => ['region_id' => 'id']],
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
            'mistake_id' => 'Kamchilik',
            'file' => 'File',
            'departament_id' => 'Departament ID',
            'status' => 'holati',
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
     * Gets query for [[Mistake]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMistake()
    {
        return $this->hasOne(Mistakes::class, ['code' => 'mistake_id']);
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
