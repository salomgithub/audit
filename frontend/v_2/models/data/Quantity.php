<?php

namespace app\models\data;

use Yii;

/**
 * This is the model class for table "quantity".
 *
 * @property int $id
 * @property string $name
 *
 * @property Mistakes[] $mistakes
 */
class Quantity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quantity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id'], 'integer'],
            [['name'], 'string', 'max' => 20],
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
     * Gets query for [[Mistakes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMistakes()
    {
        return $this->hasMany(Mistakes::class, ['quantity' => 'id']);
    }
}
