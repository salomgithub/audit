<?php

namespace app\models\data;

use app\models\TekdanKeyinBartaraf;
use app\models\TekDavBartaraf;
use Yii;

/**
 * This is the model class for table "mistakes".
 *
 * @property int $code
 * @property string $name
 * @property int $quantity miqdor(sum yoki son)
 * @property int $status Kamchilik tasnifi
 * @property string $create_at
 * @property int $head_mistakes_group_code
 * @property int $mistakes_group_code
 *
 * @property HeadMistakesGroup $headMistakesGroupCode
 * @property MistakesGroup $mistakesGroupCode
 * @property Quantity $quantity0
 * @property Status $status0
 * @property TekDavBartaraf[] $tekDavBartarafs
 * @property TekdanKeyinBartaraf[] $tekdanKeyinBartarafs
 * @property Work[] $works
 */
class Mistakes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mistakes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name', 'quantity', 'status','uzlashtirish', 'head_mistakes_group_code', 'mistakes_group_code'], 'required'],
            [['code', 'quantity', 'status','uzlashtirish', 'head_mistakes_group_code','uzlashtirish', 'mistakes_group_code'], 'integer'],
            [['create_at'], 'safe'],
            [['name'], 'string', 'max' => 200],
            [['code'], 'unique'],
            [['mistakes_group_code'], 'exist', 'skipOnError' => true, 'targetClass' => MistakesGroup::class, 'targetAttribute' => ['mistakes_group_code' => 'code']],
            [['head_mistakes_group_code'], 'exist', 'skipOnError' => true, 'targetClass' => HeadMistakesGroup::class, 'targetAttribute' => ['head_mistakes_group_code' => 'code']],
            [['quantity'], 'exist', 'skipOnError' => true, 'targetClass' => Quantity::class, 'targetAttribute' => ['quantity' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'name' => 'nomi',
            'quantity' => 'miqdori(son yoki summa)',
            'status' => 'Holat',
            'create_at' => 'yaratilgan vaqt',
            'head_mistakes_group_code' => 'Head kamchilik Group Code',
            'mistakes_group_code' => 'kamchilik Group Code',
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
     * Gets query for [[MistakesGroupCode]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMistakesGroupCode()
    {
        return $this->hasOne(MistakesGroup::class, ['code' => 'mistakes_group_code']);
    }

    /**
     * Gets query for [[Quantity0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuantity0()
    {
        return $this->hasOne(Quantity::class, ['id' => 'quantity']);
    }

    /**
     * Gets query for [[Status0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Status::class, ['id' => 'status']);
    }

    /**
     * Gets query for [[TekDavBartarafs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTekDavBartarafs()
    {
        return $this->hasMany(TekDavBartaraf::class, ['mistake_id' => 'code']);
    }

    /**
     * Gets query for [[TekdanKeyinBartarafs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTekdanKeyinBartarafs()
    {
        return $this->hasMany(TekdanKeyinBartaraf::class, ['mistake_id' => 'code']);
    }

    /**
     * Gets query for [[Works]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorks()
    {
        return $this->hasMany(Work::class, ['mistake_code' => 'code']);
    }
}
