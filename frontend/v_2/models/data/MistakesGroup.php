<?php

namespace app\models\data;

use Yii;

/**
 * This is the model class for table "mistakes_group".
 *
 * @property int $code
 * @property string $name
 * @property int $head_mistakes_group_code
 *
 * @property HeadMistakesGroup $headMistakesGroupCode
 * @property Mistakes[] $mistakes
 */
class MistakesGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mistakes_group';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name', 'head_mistakes_group_code'], 'required'],
            [['code', 'head_mistakes_group_code'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['name'], 'unique'],
            [['code'], 'unique'],
            [['head_mistakes_group_code'], 'exist', 'skipOnError' => true, 'targetClass' => HeadMistakesGroup::class, 'targetAttribute' => ['head_mistakes_group_code' => 'code']],
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
            'head_mistakes_group_code' => 'Head Mistakes Group Code',
        ];
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
     * Gets query for [[Mistakes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMistakes()
    {
        return $this->hasMany(Mistakes::class, ['mistakes_group_code' => 'code']);
    }
}
