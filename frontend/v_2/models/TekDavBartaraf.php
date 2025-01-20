<?php

namespace app\models;

use app\models\data\Branches;
use app\models\data\Mistakes;
use app\models\data\Orders;
use app\models\data\Regions;
use Yii;

/**
 * This is the model class for table "tek_dav_bartaraf".
 *
 * @property int $id
 * @property int|null $farmoish_id
 * @property int|null $region_id
 * @property int|null $branch_id
 * @property int|null $mistake_id
 * @property int|null $bartaraf_son
 * @property int|null $bartaraf_sum
 * @property string|null $file
 *
 * @property Branches $branch
 * @property Orders $farmoish
 * @property Mistakes $mistake
 * @property Regions $region
 */
class TekDavBartaraf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tek_dav_bartaraf';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['farmoish_id', 'region_id', 'branch_id', 'mistake_id', 'bartaraf_son', 'bartaraf_sum'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['farmoish_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['farmoish_id' => 'code']],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branches::class, 'targetAttribute' => ['branch_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::class, 'targetAttribute' => ['region_id' => 'id']],
            [['mistake_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mistakes::class, 'targetAttribute' => ['mistake_id' => 'code']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'farmoish_id' => 'Farmoish ID',
            'region_id' => 'Viloyat',
            'branch_id' => 'Filial',
            'mistake_id' => 'kamchilik ID',
            'bartaraf_son' => 'Bartaraf Son',
            'bartaraf_sum' => 'Bartaraf Sum',
            'file' => 'File',
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
     * Gets query for [[Farmoish]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFarmoish()
    {
        return $this->hasOne(Orders::class, ['code' => 'farmoish_id']);
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
