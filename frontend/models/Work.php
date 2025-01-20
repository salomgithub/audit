<?php

namespace app\models;

use app\models\data\Branches;
use app\models\data\Departaments;
use app\models\data\HeadMistakesGroup;
use app\models\data\Mistakes;
use app\models\data\Orders;
use app\models\data\Regions;
use frontend\models\SignupForm;
use mdm\admin\models\User;
use Yii;

/**
 * This is the model class for table "work".
 *
 * @property int $id
 * @property int $farmoyish_id
 * @property int $region_id
 * @property int $branch_id
 * @property string $year
 * @property int $unical кредитдан ташқари ҳолларда уникалка
 * @property int $hisob_raqam hisob raqam
 * @property string $client_name
 * @property int $head_mistakes_group_code
 * @property int $mistake_code
 * @property int $mistake_soni
 * @property float $mistake_sum
 * @property string $mistak_from_user xato qilgan xodim
 * @property int $user_id tekshiruvchi
 * @property int $departament_id kamchilik bartaraf qiladigan departament
 * @property string|null $comment
 *
 * @property Branches $branch
 * @property Departaments $departament
 * @property Orders $farmoyish
 * @property HeadMistakesGroup $headMistakesGroupCode
 * @property Mistakes $mistakeCode
 * @property Regions $region
 * @property Regions $work_status
 */
class Work extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'work';
    }

    public function rules()
    {
        return [
            [['farmoyish_id', 'region_id', 'branch_id', 'year',  'client_name', 'head_mistakes_group_code', 'mistake_code', 'status', 'mistake_soni','bartaraf_soni', 'mistak_from_user', 'departament_id'], 'required'],
            [['farmoyish_id', 'region_id', 'branch_id', 'head_mistakes_group_code', 'mistake_soni','bartaraf_soni', 'user_id', 'departament_id'], 'integer'],
            [['year', 'work_status','hisob_raqam', 'unical'], 'safe'],
            [['mistake_sum','bartaraf_sum'], 'number'],
            [['client_name'], 'string', 'max' => 150],
            [['mistak_from_user', 'comment'], 'string', 'max' => 1024],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => Regions::class, 'targetAttribute' => ['region_id' => 'id']],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branches::class, 'targetAttribute' => ['branch_id' => 'id']],
            [['departament_id'], 'exist', 'skipOnError' => true, 'targetClass' => Departaments::class, 'targetAttribute' => ['departament_id' => 'id']],
            [['farmoyish_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['farmoyish_id' => 'code']],
            [['head_mistakes_group_code'], 'exist', 'skipOnError' => true, 'targetClass' => HeadMistakesGroup::class, 'targetAttribute' => ['head_mistakes_group_code' => 'code']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'farmoyish_id' => 'фармойиш',
            'region_id' => 'вилоят',
            'branch_id' => 'филиал',
            'year' => 'йил',
            'unical' => 'кредит_ид',
            'client_name' => 'мижоз',
            'head_mistakes_group_code' => 'булинма',
            'mistake_code' => 'камчилик',
            'status' => 'холат',
            'mistake_soni' => 'сон',
            'mistake_sum' => 'сумма',
            'bartaraf_soni' => 'бартараф_сон',
            'bartaraf_sum' => 'бартараф_сум',
            'mistak_from_user' => 'сабабчи',
            'user_id' => 'текширувчи',
            'departament_id' => 'департамент',
            'comment' => 'изох',
            'work_status' => 'статус',
        ];
    }

    public function getBranch()
    {
        return $this->hasOne(Branches::class, ['id' => 'branch_id']);
    }

    public function getDepartament()
    {
        return $this->hasOne(Departaments::class, ['id' => 'departament_id']);
    }

    public function getFarmoyish()
    {
        return $this->hasOne(Orders::class, ['code' => 'farmoyish_id']);
    }

    public function getHeadMistakesGroupCode()
    {
        return $this->hasOne(HeadMistakesGroup::class, ['code' => 'head_mistakes_group_code']);
    }

    public function getMistakeCode()
    {
        return $this->hasOne(Mistakes::class, ['code' => 'mistake_code']);
    }

    public function getRegion()
    {
        return $this->hasOne(Regions::class, ['id' => 'region_id']);
    }
    public function getMistakes()
    {
        return $this->hasMany(Mistakes::className(), ['work_id' => 'id']);
    }

}
