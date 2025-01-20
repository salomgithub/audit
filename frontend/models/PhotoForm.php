<?php

namespace app\models;

use Yii;


class PhotoForm  extends \yii\db\ActiveRecord
{
    public $employee_id;
    public $photo;
    public $captured_photo; // Qo'shing

    public function rules()
    {
        return [
            [['employee_id'], 'required'],
            [['employee_id'], 'integer'],
            [['photo', 'captured_photo'], 'string', 'max' => 255],
        ];
    }
}
