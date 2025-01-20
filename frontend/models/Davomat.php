<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "davomat".
 *
 * @property int $id
 * @property int|null $employee_id
 * @property string|null $photo
 * @property int|null $action
 * @property string|null $time
 * @property int|null $sabab
 */
class Davomat extends \yii\db\ActiveRecord
{

    public $captured_photo;
    public static function tableName()
    {
        return 'davomat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'photo'], 'required'],
            [['employee_id'], 'integer'],
            [['time', 'sabab','action'], 'safe'],
            [['photo'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_id' => 'FIO',
            'photo' => 'Rasm',
            'action' => 'Kirish/Chiqish',
            'time' => 'Vaqt',
            'sabab' => 'Sabab',
        ];
    }
}
