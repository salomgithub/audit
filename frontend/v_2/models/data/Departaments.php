<?php

namespace app\models\data;

use Yii;

/**
 * This is the model class for table "departaments".
 *
 * @property int $id
 * @property string $name
 *
 * @property TekdanKeyinBartaraf[] $tekdanKeyinBartarafs
 * @property Work[] $works
 */
class Departaments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departaments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
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
        ];
    }

    /**
     * Gets query for [[TekdanKeyinBartarafs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTekdanKeyinBartarafs()
    {
        return $this->hasMany(TekdanKeyinBartaraf::class, ['departament_id' => 'id']);
    }

    /**
     * Gets query for [[Works]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorks()
    {
        return $this->hasMany(Work::class, ['departament_id' => 'id']);
    }
}
