<?php


namespace app\models;

use yii\base\Model;

class Export extends Model
{
    public $data_start;
    public $data_end;

    public function rules()
    {
        return [
            [['data_start', 'data_end'], 'required'],
        ];
    }
}
