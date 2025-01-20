<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class ImageUploadForm extends Model
{
    public $imageFile;
    public $name;

    /**
     * @var UploadedFile
     */

    public function rules()
    {
        return [
            [['name', 'imageFile'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }


    public function upload()
    {
        if ($this->validate()) {
            $imageName = $this->name . '.' . $this->imageFile->extension;
            $this->imageFile->saveAs(Yii::getAlias('@web/uploads/') . $imageName);
            return true;
        } else {
            return false;
        }
    }
}
