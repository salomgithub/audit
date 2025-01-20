<?php

namespace app\models\data;

use Yii;

/**
 * This is the model class for table "regions".
 *
 * @property int $id
 * @property string $name
 *
 * @property Branches[] $branches
 * @property TekDavBartaraf[] $tekDavBartarafs
 * @property TekdanKeyinBartaraf[] $tekdanKeyinBartarafs
 * @property Work[] $works
 */
class Regions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'regions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 50],
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
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Branches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branches::class, ['region_id' => 'id']);
    }

    /**
     * Gets query for [[TekDavBartarafs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTekDavBartarafs()
    {
        return $this->hasMany(TekDavBartaraf::class, ['region_id' => 'id']);
    }

    /**
     * Gets query for [[TekdanKeyinBartarafs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTekdanKeyinBartarafs()
    {
        return $this->hasMany(TekdanKeyinBartaraf::class, ['region_id' => 'id']);
    }

    /**
     * Gets query for [[Works]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorks()
    {
        return $this->hasMany(Work::class, ['region_id' => 'id']);
    }
}
