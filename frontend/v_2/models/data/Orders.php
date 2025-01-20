<?php

namespace app\models\data;

use app\models\TekDavBartaraf;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "Orders".
 *
 * @property int $code
 * @property int $region_id
 * @property int $branch_id
 * @property int $user_id
 * @property string $file
 * @property string created_at
 *
 * @property TekDavBartaraf[] $tekDavBartarafs
 * @property TekdanKeyinBartaraf[] $tekdanKeyinBartarafs
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'region_id'], 'required'],
            [['code', 'region_id', 'branch_id'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Farmoyish nomeri',
            'region_id' => 'Viloyat',
            'branch_id' => 'Filial',
            'created_at' => 'Sana',
//            'user_id' => 'User ID',
            'file' => 'Farmoyish fayli',
        ];
    }
    public function upload($id)
    {
        if ($this->validate()) {
            $file = UploadedFile::getInstance($this, 'file');
            if ($file !== null) {
                $filePath = 'uploads/farmoyish/' . $id . '.' . $file->extension;
                if ($file->saveAs($filePath)) {
                    $this->file = $filePath;
                    return true;
                }
            }
        }
        return false;
    }


}
