<?php

use app\models\data\Branches;
use app\models\data\Mistakes;
use app\models\data\Regions;
use app\models\Work;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TekDavBartaraf $model */

//$this->title = $model->code;
\yii\web\YiiAsset::register($this);
?>
<div class="tek-dav-bartaraf-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <table class="table table-bordered">
        <tbody>
        <tr>
            <th class="table-light">Farmoyish</th>
            <th class="table-light">Viloyat</th>
            <th class="table-light">Filial</th>
            <th class="table-light">Tekshirilgan yil</th>
        </tr>
        <tr>
            <td><?= $model->code ?></td>
            <td><?= Regions::findOne($model->region_id)->name ?></td>
            <td><?= Branches::findOne($model->branch_id)->name ?></td>
            <td><?= $model->created_at ?></td>
        </tr>
        </tbody>
    </table>
    <h3 align="center">Aniqlanga holat bo'yicha batafsil ma'lumot</h3>
    <table class="table table-bordered">
        <tbody>
        <tr>
            <th class="table-light">Filial</th>
            <th class="table-light">kamchilik nomi</th>
            <th class="table-light">soni</th>
            <th class="table-light">summasi</th>
        </tr>
        <?php

        $branches = Work::find()
            ->select(['branch_id'])
            ->groupBy('branch_id')
            ->where(['farmoyish_id' => $model->code])
            ->asArray()
            ->all();
        $branchesData = [];
        $salomlar = [];

        foreach ($branches as $branch) {
            $data = Work::find()->where(['farmoyish_id' => $model->code, 'branch_id' => $branch['branch_id']])->all();
            $soni = 0;
            $summasi = 0;
            $branchData = [
                'name' => [],
                'items' => []
            ];
            $headmistakegroup = Work::find()
                ->select(['head_mistakes_group_code', 'SUM(mistake_soni) AS total_mistake_soni', 'SUM(mistake_sum) AS total_mistake_sum'])
                ->where(['branch_id' => $branch['branch_id'], 'farmoyish_id' => $model->code])
                ->groupBy('head_mistakes_group_code')
                ->asArray()
                ->all();
            $salom = [
                'name' => Branches::findOne($branch['branch_id'])->name,
                'head' => [],
                'mistake' => [],
                'mistakes' => [],
            ];
            echo "<pre>";
            foreach ($headmistakegroup as $item) {
                $name = \app\models\data\HeadMistakesGroup::findOne($item['head_mistakes_group_code'])->name;
                $salom['head'] = $name;
                $cleints = Work::find()
                    ->select(['mistakes.name', 'work.client_name', 'work.mistake_sum'])
                    ->join('JOIN', 'mistakes', 'mistakes.code = work.mistake_code')
                    ->where(['farmoyish_id' => $model->code, 'branch_id' => $branch['branch_id'], 'work.head_mistakes_group_code' => $item['head_mistakes_group_code']])
                    ->orderBy(['mistake_code' => SORT_ASC])
                    ->asArray()
                    ->all();
                $mistakes_number = Work::find()
                    ->select(['work.mistake_code', 'mistakes.name', 'SUM(work.mistake_soni) as mistake_soni'])
                    ->join('JOIN', 'mistakes', 'mistakes.code = work.mistake_code')
                    ->where(['farmoyish_id' => 387, 'branch_id' => $branch['branch_id'], 'work.head_mistakes_group_code' => $item['head_mistakes_group_code']])
                    ->groupBy('work.mistake_code')
                    ->orderBy(['work.mistake_code' => SORT_ASC])
                    ->asArray()
                    ->all();
                $a = [];
                foreach ($mistakes_number as $item) {
                    $a['mistake_code'] = $item['mistake_code'];
                    $a['mistake_name'] = $item['name'];
                    $a['mistake_soni'] = $item['mistake_soni'];
                    $cleints = Work::find()
                        ->select(['mistakes.name', 'work.client_name', 'work.mistake_sum'])
                        ->join('JOIN', 'mistakes', 'mistakes.code = work.mistake_code')
                        ->where(['farmoyish_id' => $model->code, 'branch_id' => $branch['branch_id'], 'mistake_code' => $item['mistake_code']])
                        ->orderBy(['mistake_code' => SORT_ASC])
                        ->asArray()
                        ->all();
                    $a['fio'] = $cleints;
                    $salom['mistake'][] = $a;
//                    var_dump($salom);die();
                }

//                $salom['mistake'][] = $mistakes_number;
//
//                $salom['mistakes'][] = $cleints;

            }
            $salomlar[] = $salom;
            ?>
            <tr>
                <td><?= Branches::findOne($branch['branch_id'])->name ?></td>
                <?php
                foreach ($data as $item) {
                    echo "<td>" . \app\models\data\Mistakes::findOne($item->mistake_code)->name . "</td>";
                    echo "<td>" . $item->mistake_soni . "</td>";
                    echo "<td>" . $item->mistake_sum . "</td></tr><tr><td></td>";

                    $branchData['mistakes'][] = 1;
                    $branchData['mistakes'][] = 2;
                    $branchData['mistakes'][] = 3;
                    $soni += $item->mistake_soni;
                    $summasi += $item->mistake_sum;

                }
                $branchData['total_soni'] = $soni;
                $branchData['total_summasi'] = $summasi;

                $branchesData[] = $branchData;
                ?>
                </td>
            </tr>
            <tr>
                <td>Jami :</td>
                <td></td>
                <td><?= $soni ?> </td>
                <td><?= $summasi ?> </td>
            </tr>
        <?php } ?>
        <pre>
        <?
        //        var_dump($branchesData);
//        echo $salomlar[0]['name'] . "<br>";
//        echo $salomlar[0]['head'] . "<br>";
//        echo $salomlar[0]['mistake'][0][0]['mistake_name'] . "<br>";
        //        echo $salomlar[0]['mistake'][0][0]['mistake_soni']."-<br>";
        //        echo $salomlar[0]['mistake'][0][0]['mistake_sum']."-<br><br>";

        //        echo $salomlar[0]['mistakes'][0]['total_mistake_soni']."<br>";
        //        echo $salomlar[0]['mistakes'][0]['total_mistake_sum']."<br>";
        //        echo $salomlar[0]['mistakes'][0][0]['client_name']."<br>";
        echo "<hr>";
        var_dump($salomlar);
        ?>
        </tbody>
    </table>
    <?= Html::a('AKT rasmiylashtirish', ['akt', 'code' => $model->code], ['class' => 'btn btn-primary']) ?>
    <table>
        <?php
        foreach ($branchesData as $branchesDatum) {
//            echo "<tr>".$branchesDatum['name'];
//            echo "<tr>".$branchesDatum['name'];
        }


        ?>
        <tr></tr>
    </table>

    </pre>
</div>
