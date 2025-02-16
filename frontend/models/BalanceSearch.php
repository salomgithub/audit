<?php

namespace app\models;

use DivisionByZeroError;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Balance;

/**
 * BalanceSearch represents the model behind the search form of `app\models\Balance`.
 */
class BalanceSearch extends Balance
{
    public $branch_id;
    public $region_id;

    public function rules()
    {
        return [
            [['id', 'branch_id', 'kirim_passiv', 'debet', 'kredit', 'chiqim_aktiv', 'chiqim_passiv'], 'integer'],
            [['hisob_raqam', 'hisob_raqam_nomi', 'kirim_aktiv', 'from_data', 'to_data'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Balance::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'kirim_passiv' => $this->kirim_passiv,
            'debet' => $this->debet,
            'kredit' => $this->kredit,
            'chiqim_aktiv' => $this->chiqim_aktiv,
            'chiqim_passiv' => $this->chiqim_passiv,
            'from_data' => $this->from_data,
            'to_data' => $this->to_data,
        ]);

        $query->andFilterWhere(['like', 'hisob_raqam', $this->hisob_raqam])
            ->andFilterWhere(['like', 'hisob_raqam_nomi', $this->hisob_raqam_nomi])
            ->andFilterWhere(['like', 'kirim_aktiv', $this->kirim_aktiv]);

        return $dataProvider;
    }

    public function search_aktivlar($params)
    {

        $query = Balance::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'branch_id' => $this->branch_id,
            'from_data' => $this->from_data,
            'to_data' => $this->to_data,
        ]);

        $branch_id = $this->branch_id;
        $from_data = $this->from_data;
        $to_data = $this->to_data;


        return $this->aktivlar($branch_id, $from_data, $to_data);
    }

    public function aktivlar($branch_id, $from_data, $to_data)
    {
        $a = Balance::find()
                ->where(['hisob_raqam' => 11100])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $a1 = Balance::find()
                ->where(['hisob_raqam' => 11100])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $b = Balance::find()
                ->where(['hisob_raqam_nomi' => [12600, 12100, 12300, 12400, 12500, 12700, 12900, 13000, 13100, 13200, 13300]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $b1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [12600, 12100, 12300, 12400, 12500, 12700, 12900, 13000, 13100, 13200, 13300]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;


        $v = Balance::find()
                ->where(['hisob_raqam_nomi' => [14300, 14500, 14700, 14900, 15000, 15100, 15200, 15300, 15400, 15500, 14800]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $v1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [14300, 14500, 14700, 14900, 15000, 15100, 15200, 15300, 15400, 15500, 14800]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $g = 0;
        $g1 = 0;

        $d = Balance::find()
                ->where(['hisob_raqam_nomi' => 15700])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $d1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 15700])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $e = Balance::find()
                ->where(['hisob_raqam_nomi' => 15900])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $e1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 15900])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $j = Balance::find()
                ->where(['hisob_raqam_nomi' => 15800])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $j1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 15800])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $yo = Balance::find()
                ->where(['hisob_raqam' => [16101, 16102]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $yo1 = Balance::find()
                ->where(['hisob_raqam' => [16101, 16102]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_a = Balance::find()
                ->where(['hisob_raqam' => [16104, 16105, 16107, 16109]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $_a1 = Balance::find()
                ->where(['hisob_raqam' => [16104, 16105, 16107, 16109]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_b = Balance::find()
                ->where(['hisob_raqam_nomi' => [16300, 16400]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $_b1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [16300, 16400]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_v = Balance::find()
                ->where(['hisob_raqam_nomi' => [16500, 16600, 16700]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $_v1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [16500, 16600, 16700]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_g = Balance::find()
                ->where(['hisob_raqam_nomi' => [17100]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $_g1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [17100]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_d = Balance::find()
                ->where(['hisob_raqam_nomi' => [17300, 17400]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $_d1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [17300, 17400]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_e = Balance::find()
                ->where(['hisob_raqam_nomi' => [17500, 10700, 10800]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $_e1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [17500, 10700, 10800]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_j = Balance::find()
                ->where(['hisob_raqam_nomi' => 19900])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $_j1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 19900])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $shundan1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 10100])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $shundan1 = $shundan1 - Balance::find()
                ->where(['hisob_raqam' => 10109])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $shundan1_2 = Balance::find()
                ->where(['hisob_raqam_nomi' => 10100])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;
        $shundan1_2 = $shundan1_2 - Balance::find()
                ->where(['hisob_raqam' => 10109])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;


        $shundan2 = Balance::find()
                ->where(['hisob_raqam_nomi' => [10300, 10500]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $shundan2 += Balance::find()
                ->where(['hisob_raqam' => [10109]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $shundan2 = $shundan2 - Balance::find()
                ->where(['hisob_raqam' => [10309]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $shundan2_2 = Balance::find()
                ->where(['hisob_raqam_nomi' => [10300, 10500]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;
        $shundan2_2 += Balance::find()
                ->where(['hisob_raqam' => [10109]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $shundan2_2 = $shundan2_2 - Balance::find()
                ->where(['hisob_raqam' => [10309]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $shundan3 = Balance::find()
                ->where(['hisob_raqam' => [10309]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $shundan3_2 = Balance::find()
                ->where(['hisob_raqam' => [10309]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $shundan4 = Balance::find()
                ->where(['hisob_raqam' => [16103]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $shundan4_2 = Balance::find()
                ->where(['hisob_raqam' => [16103]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $shundan5 = Balance::find()
                ->where(['hisob_raqam' => [16113, 16111]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $shundan5_2 = Balance::find()
                ->where(['hisob_raqam' => [16113, 16111]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_yo = $shundan1 + $shundan2 + $shundan3 + $shundan4 + $shundan5;
        $_yo1 = $shundan1_2 + $shundan2_2 + $shundan3_2 + $shundan4_2 + $shundan5_2;

        $daromad = $a + $b + $v + $g + $d + $e + $j + $yo;
        $daromad1 = $a1 + $b1 + $v1 + $g1 + $d1 + $e1 + $j1 + $yo1;

        $daromad_emas = $_a + $_b + $_v + $_g + $_d + $_e + $_j + $_yo;
        $daromad_emas1 = $_a1 + $_b1 + $_v1 + $_g1 + $_d1 + $_e1 + $_j1 + $_yo1;

        $all = [
            'daromad' => $daromad,
            'daromad1' => $daromad1,
            'daromad_emas' => $daromad_emas,
            'daromad_emas1' => $daromad_emas1,
            'jami1' => $daromad_emas + $daromad,
            'jami2' => $daromad_emas1 + $daromad1
        ];
        try {
            if ($daromad === 0 || $daromad_emas === 0 || $daromad1 === 0 || $daromad_emas1 === 0) {
                throw new DivisionByZeroError("Daromad va daromad emas 0 ga teng bo'lishi mumkin emas.");
                die();
            }
            $aktivlar[]["jami_a"] = ['name' => "<b>Даромад келтирувчи активлар</b>", 'jami_summa1' => $daromad, 'jami_foiz1' => $daromad * 100 / ($daromad + $daromad_emas), 'jami_summa2' => $daromad1, 'foiz2' => $daromad1 * 100 / ($daromad1 + $daromad_emas1), 'farqi' => $daromad1 - $daromad];
            $aktivlar[]["a"] = ['name' => "- факторинг", 'summa1' => $a, 'foiz1' => $a * 100 / $daromad, 'summa2' => $a1, 'foiz2' => $a1 * 100 / $daromad1, 'farqi' => $a1 - $a];
            $aktivlar[]["b"] = ['name' => "- қисқа муддатли ва муддати утган ссудалар", 'summa1' => $b, 'foiz1' => $b * 100 / $daromad, 'summa2' => $b1, 'foiz2' => $b1 * 100 / $daromad1, 'farqi' => $b1 - $b];
            $aktivlar[]["v"] = ['name' => "- узоқ муддатли ссудалар", 'summa1' => $v, 'foiz1' => $v * 100 / $daromad, 'summa2' => $v1, 'foiz2' => $v1 * 100 / $daromad1, 'farqi' => $v1 - $v];
            $aktivlar[]["g"] = ['name' => "- лизинг", 'summa1' => $g, 'foiz1' => $g * 100 / $daromad, 'summa2' => $g1, 'foiz2' => $g1 * 100 / $daromad1, 'farqi' => $g1 - $g];
            $aktivlar[]["d"] = ['name' => "- суд жараёнидаги кредитлар ва лизинг", 'summa1' => $d, 'foiz1' => $d * 100 / $daromad, 'summa2' => $d1, 'foiz2' => $g1 * 100 / $daromad1, 'farqi' => $d1 - $d];
            $aktivlar[]["e"] = ['name' => "- сўндириш муддатигача сакланадиган карз кимматли когозларга килинган инвестициялар", 'summa1' => $e, 'foiz1' => $e * 100 / $daromad, 'summa2' => $e1, 'foiz2' => $e1 * 100 / $daromad1, 'farqi' => $e1 - $e];
            $aktivlar[]["j"] = ['name' => "- қўшма корхоналарга инвестиция", 'summa1' => $j, 'foiz1' => $j * 100 / $daromad, 'summa2' => $j1, 'foiz2' => $j1 * 100 / $daromad1, 'farqi' => $j1 - $j];
            $aktivlar[]["yo"] = ['name' => "- банк филиалларига берилган молиявий ёрдам ва ресурслар", 'summa1' => $yo, 'foiz1' => $yo * 100 / $daromad, 'summa2' => $yo1, 'foiz2' => $yo1 * 100 / $daromad1, 'farqi' => $yo1 - $yo];

            $aktivlar[]["jami_a"] = ['name' => "<b>Даромад келтирмайдиган активлар</b>", 'jami_summa1' => $daromad_emas, 'jami_foiz1' => $daromad_emas * 100 / ($daromad + $daromad_emas), 'jami_summa2' => $daromad_emas1, 'foiz2' => $daromad_emas1 * 100 / ($daromad1 + $daromad_emas1), 'farqi' => $daromad_emas1 - $daromad_emas];
            $aktivlar[]["a"] = ['name' => "- бош офисдан товар материал олиш учун ўтказилган маблағлар", 'summa1' => $_a, 'foiz1' => $_a * 100 / $daromad_emas, 'summa2' => $_a1, 'foiz2' => $_a1 * 100 / $daromad_emas1, 'farqi' => $_a1 - $_a];
            $aktivlar[]["b"] = ['name' => "- ҳисобланган, лекин ундирилмаган фоизлар", 'summa1' => $_b, 'foiz1' => $_b * 100 / $daromad_emas, 'summa2' => $_b1, 'foiz2' => $_b1 * 100 / $daromad_emas1, 'farqi' => $_b1 - $_b];
            $aktivlar[]["v"] = ['name' => "- банк мулклари", 'summa1' => $_v, 'foiz1' => $_v * 100 / $daromad_emas, 'summa2' => $_v1, 'foiz2' => $_v1 * 100 / $daromad_emas1, 'farqi' => $_v1 - $_v];
            $aktivlar[]["g"] = ['name' => "- чет эл валюталарининг сўмдаги қиймати", 'summa1' => $_g, 'foiz1' => $_g * 100 / $daromad_emas, 'summa2' => $_g1, 'foiz2' => $_g1 * 100 / $daromad_emas1, 'farqi' => $_g1 - $_g];
            $aktivlar[]["d"] = ['name' => "- транзит счетлар", 'summa1' => $_d, 'foiz1' => $_d * 100 / $daromad_emas, 'summa2' => $_d1, 'foiz2' => $_g1 * 100 / $daromad_emas1, 'farqi' => $_d1 - $_d];
            $aktivlar[]["e"] = ['name' => "- давлат ҳисоб рақамлари", 'summa1' => $_e, 'foiz1' => $_e * 100 / $daromad_emas, 'summa2' => $_e1, 'foiz2' => $_e1 * 100 / $daromad_emas1, 'farqi' => $_e1 - $_e];
            $aktivlar[]["j"] = ['name' => "- бошқа активлар", 'summa1' => $_j, 'foiz1' => $_j * 100 / $daromad_emas, 'summa2' => $_j1, 'foiz2' => $_j1 * 100 / $daromad_emas1, 'farqi' => $_j1 - $_j];
            $aktivlar[]["yo"] = ['name' => "- юқори ликвидли активлар", 'summa1' => $_yo, 'foiz1' => $_yo * 100 / $daromad_emas, 'summa2' => $_yo1, 'foiz2' => $_yo1 * 100 / $daromad_emas1, 'farqi' => $_yo1 - $_yo];
            $aktivlar[]["shundan1"] = ['name' => "   - кассадаги нақд пуллар ва қимматбаҳо металлар", 'summa1' => $shundan1, 'foiz1' => $shundan1 * 100 / $daromad_emas, 'summa2' => $shundan1_2, 'foiz2' => $shundan1_2 * 100 / $daromad_emas1, 'farqi' => $shundan1_2 - $shundan1];
            $aktivlar[]["shundan2"] = ['name' => "   - йўлдаги пуллар", 'summa1' => $shundan2, 'foiz1' => $shundan2 * 100 / $daromad_emas, 'summa2' => $shundan2_2, 'foiz2' => $shundan2_2 * 100 / $daromad_emas1, 'farqi' => $shundan2_2 - $shundan2];
            $aktivlar[]["shundan3"] = ['name' => "   - мажбурий заҳира фондидаги маблағлар", 'summa1' => $shundan3, 'foiz1' => $shundan3 * 100 / $daromad_emas, 'summa2' => $shundan3_2, 'foiz2' => $shundan3_2 * 100 / $daromad_emas1, 'farqi' => $shundan3_2 - $shundan3];
            $aktivlar[]["shundan4"] = ['name' => "   - ягона вакиллик ҳисобварағидаги маблағлар", 'summa1' => $shundan4, 'foiz1' => $shundan4 * 100 / $daromad_emas, 'summa2' => $shundan4_2, 'foiz2' => $shundan4_2 * 100 / $daromad_emas1, 'farqi' => $shundan4_2 - $shundan4];
            $aktivlar[]["shundan5"] = ['name' => "   -паластик картлардан амалга оширилган туловлар буйича бошка банклардан олинадиган маблаглар", 'summa1' => $shundan5, 'foiz1' => $shundan5 * 100 / $daromad_emas, 'summa2' => $shundan5_2, 'foiz2' => $shundan5_2 * 100 / $daromad_emas1, 'farqi' => $shundan5_2 - $shundan5];

            $aktivlar['Даромад эмас']["jami"] = [
                'name' => "<b>Жами активлар</b>", 'summa1' => $daromad_emas + $daromad,
                'foiz1' => $daromad * 100 / ($daromad + $daromad_emas) + $daromad_emas * 100 / ($daromad + $daromad_emas),
                'summa2' => $daromad_emas1 + $daromad1,
                'foiz2' => $daromad_emas1 * 100 / ($daromad1 + $daromad_emas1) + $daromad1 * 100 / ($daromad1 + $daromad_emas1),
                'farqi' => (($daromad_emas1 + $daromad1) - ($daromad_emas + $daromad))
            ];
        } catch (DivisionByZeroError $e) {
            echo "<script>alert('Xatolik1: bunday vaqt oralig\'ida ma\'lumotlar to\'lliq topilmadi.');</script>";
            $message = 0;
            $this->addError('from_data', "Xatolik2: bu filial bo'yicha  ushbu vaqt oralig'ida ma'lumotlar to'liq topilmadi.");
            return $message;
        } catch (Exception $e) {
            $message=1;
            $this->addError('from_data', "Xatolik3: bu filial bo'yicha  ushbu vaqt oralig'ida ma'lumotlar to'liq topilmadi. $e->getMessage();");
            return $message;
        }
        return $aktivlar;
    }

}
