<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class CodeForm extends Model
{
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xlsx'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->file->saveAs('uploads/' . $this->file->baseName . '.' . $this->file->extension);
            return true;
        } else {
            return false;
        }
    }

    public function getArrayDataFromExcel()
    {
        $objPHPExcel = \PhpOffice\PhpSpreadsheet\IOFactory::load('uploads/' . $this->file->baseName . '.' . $this->file->extension);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

        return $sheetData;
    }
}
