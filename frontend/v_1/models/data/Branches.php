<?php

namespace app\models\data;

use Yii;

/**
 * This is the model class for table "branches".
 *
 * @property int $id
 * @property string $name
 * @property int $region_id
 *
 * @property Regions $region
 * @property TekDavBartaraf[] $tekDavBartarafs
 * @property TekdanKeyinBartaraf[] $tekdanKeyinBartarafs
 * @property Work[] $works
 */
class Branches extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branches';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name', 'region_id'], 'required'],
            [['id', 'region_id'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['id'], 'unique'],
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
            'name' => 'Nomi',
            'region_id' => 'Viloyat kodi',
        ];
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

    /**
     * Gets query for [[TekDavBartarafs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTekDavBartarafs()
    {
        return $this->hasMany(TekDavBartaraf::class, ['branch_id' => 'id']);
    }

    /**
     * Gets query for [[TekdanKeyinBartarafs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTekdanKeyinBartarafs()
    {
        return $this->hasMany(TekdanKeyinBartaraf::class, ['branch_id' => 'id']);
    }

    /**
     * Gets query for [[Works]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorks()
    {
        return $this->hasMany(Work::class, ['branch_id' => 'id']);
    }
}
