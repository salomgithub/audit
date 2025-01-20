<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doc_log".
 *
 * @property int $id
 * @property int $work_id
 * @property int $user_id
 * @property string $action
 * @property int $status_old
 * @property int $status_new
 * @property string $create_at
 * @property string $ip
 */
class DocLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doc_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['work_id', 'user_id', 'status_old', 'status_new'], 'integer'],
            [['create_at'], 'safe'],
            [['action', 'ip'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'work_id' => 'Work ID',
            'user_id' => 'User ID',
            'action' => 'Action',
            'status_old' => 'Status Old',
            'status_new' => 'Status New',
            'create_at' => 'Create At',
            'ip' => 'Ip',
        ];
    }
}
