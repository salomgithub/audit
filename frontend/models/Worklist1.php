<?php

namespace frontend\models;

use app\models\Work;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "work_list".
 *
 * @property int $id
 * @property int|null $work_id
 * @property string|null $file
 * @property string|null $commet
 * @property int|null $status
 *
 * @property Work $work
 */
class Worklist extends \yii\db\ActiveRecord
{
    /**
     * @var mixed|null
     */

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'work_list';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file'], 'required'],
            [['file'], 'file', 'extensions' => ['pdf']],
            [['work_id', 'dep_id', 'status'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['commet','mistake_name'], 'string', 'max' => 255],
            [['work_id'], 'exist', 'skipOnError' => true, 'targetClass' => Work::class, 'targetAttribute' => ['work_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'work_id' => 'Kamchilik ID',
            'mistake_name' => 'Kamchilik nomi',
            'file' => 'File',
            'commet' => 'Commet',
            'status' => 'Status',
        ];
    }

    public function upload($id)
    {
            $file = UploadedFile::getInstance($this, 'file');
            if ($file !== null) {
                $filePath = 'uploads/depbartaraf/' . $id . '.' . $file->extension;
                if ($file->saveAs($filePath)) {
                    $this->file = $filePath;
                    return true;
                }
            }
        return false;
    }

    /**
     * Gets query for [[Work]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWork()
    {
        return $this->hasOne(Work::class, ['id' => 'work_id']);
    }
}
