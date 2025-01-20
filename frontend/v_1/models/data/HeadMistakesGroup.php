<?php

namespace app\models\data;

use Yii;

/**
 * This is the model class for table "head_mistakes_group".
 *
 * @property int $code
 * @property string $name
 *
 * @property Mistakes[] $mistakes
 * @property MistakesGroup[] $mistakesGroups
 */
class HeadMistakesGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'head_mistakes_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
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
        return $this->hasMany(Mistakes::class, ['head_mistakes_group_code' => 'code']);
    }

    /**
     * Gets query for [[MistakesGroups]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMistakesGroups()
    {
        return $this->hasMany(MistakesGroup::class, ['head_mistakes_group_code' => 'code']);
    }
}
