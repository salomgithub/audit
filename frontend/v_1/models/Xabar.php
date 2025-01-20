<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "xabar".
 *
 * @property int|null $work_id
 * @property string|null $xabar
 */
class Xabar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'xabar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['xabar'], 'required'],
            [['work_id'], 'integer'],
            [['xabar'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'work_id' => 'Work ID',
            'xabar' => 'Rad etish sababi',
        ];
    }
}
