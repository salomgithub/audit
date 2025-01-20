<?php

/** @var yii\web\View $this */

use app\models\data\HeadMistakesGroup;
use app\models\Work;

$this->title = 'Hisobot';
$umumiy = Work::find()->count();
$departaments = \app\models\data\Departaments::find()->all();

?>
<div class="site-index">
    <div class="  bg-transparent rounded-3">
        <div class="  text-center">
            <?php
            $head_mistakes = HeadMistakesGroup::find()->all();
            foreach ($head_mistakes as $head_mistake) {
                $s0 = Work::find()->where(['work_status' => 0, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_soni');
                $s1 = Work::find()->where(['work_status' => 1, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_soni');
                $s2 = Work::find()->where(['work_status' => 2, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_soni');

                $all = $s0 + $s1 + $s2;// Jami soni

                $u0 = Work::find()->where(['work_status' => 0, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_sum');
                $u1 = Work::find()->where(['work_status' => 1, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_sum');
                $u2 = Work::find()->where(['work_status' => 2, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_sum');

                $u = $u0 + $u1 + $u2;// Jami soni

                $dataPoints1[] = ["label" => $head_mistake->name, "symbol" => $head_mistake->name, "y" => (int)$all];
                $dataPoints2[] = ["label" => $head_mistake->name, "symbol" => $head_mistake->name, "y" => (int)$u];

            }
            ?>
            <div>
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
            </div>
            <?php
            $this->registerJsFile("@web/js/canvasjs.min.js", [
                'depends' => [
                    \yii\web\JqueryAsset::className()
                ]
            ]);
            ?>
            <table class="table table-striped table-bordered">
                <tr>
                    <th rowspan="3">Таркибий бўлинмалар номи</th>
                    <th colspan="6">Кредит амалиётлари бўйича камчиликлар</th>
                    <th colspan="6">Бухгалтерия амалиёти бўйича</th>
                    <th colspan="6">Чакана амалиётлар</th>
                    <th colspan="6">Банк карталари сектори</th>
                    <th colspan="6">Касса амалиётлари бўйича</th>

                </tr>
                <tr>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>
                    <th colspan="2">Шундан ўзлаштирилган</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>
                    <th colspan="2">Шундан ўзлаштирилган</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>
                    <th colspan="2">Шундан ўзлаштирилган</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>
                    <th colspan="2">Шундан ўзлаштирилган</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>
                    <th colspan="2">Шундан ўзлаштирилган</th>


                </tr>
                <tr>
                    <th>Сони</th>
                    <th>Суммаси</th>
                    <th>Сони</th>
                    <th>Суммаси</th>
                    <th>Сони</th>
                    <th>Суммаси</th>
                    <th>Сони</th>
                    <th>Суммаси</th>
                    <th>Сони</th>
                    <th>Суммаси</th>
                    <th>Сони</th>
                    <th>Суммаси</th>
                    <th>Сони</th>
                    <th>Суммаси</th>
                    <th>Сони</th>
                    <th>Суммаси</th>
                    <th>Сони</th>
                    <th>Суммаси</th>
                    <th>Сони</th>
                    <th>Суммаси</th>

                </tr>

                <?php
                $head_mistakes = HeadMistakesGroup::find()->all();
                foreach ($departaments as $departament) {
                    echo "<tr>";
                    echo "<td>" . $departament->name . "</td>";
                    foreach ($head_mistakes as $head_mistake) {

                        $son0 = Work::find()->where(['work_status' => 0, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_soni');
                        $son1 = Work::find()->where(['work_status' => 1, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_soni');
                        $son2 = Work::find()->where(['work_status' => 2, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_soni');

                        $son = $son0 + $son1 + $son2;// Jami soni

                        if ($son > 0) {

                            $sum0 = Work::find()->where(['work_status' => 0, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_sum');
                            $sum1 = Work::find()->where(['work_status' => 1, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_sum');
                            $sum2 = Work::find()->where(['work_status' => 2, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_sum');
                            $sum0 = is_numeric($sum0) ? $sum0 : 0;
                            $sum1 = is_numeric($sum1) ? $sum1 : 0;
                            $sum = $sum0 + $sum1 + $sum2;  //jami summa

                            $bartaraf_son = Work::find()->where(['work_status' => 2, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_soni');
                            $bartaraf_sum = Work::find()->where(['work_status' => 2, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_sum');

                            $bartaraf_son = is_numeric($bartaraf_son) ? $bartaraf_son : 0;//bartaraf soni
                            $bartaraf_sum = is_numeric($bartaraf_sum) ? $bartaraf_sum : 0;//bartaraf summa


                            $uzlashtirilgan_son = Work::find()->where(['uzlashtirish' => 1, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_soni');
                            $uzlashtirilgan_sum = Work::find()->where(['uzlashtirish' => 1, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_sum');

                            $uzlashtirilgan_son = is_numeric($uzlashtirilgan_son) ? $uzlashtirilgan_son : 0;//uzlashtirish soni
                            $uzlashtirilgan_sum = is_numeric($uzlashtirilgan_sum) ? $uzlashtirilgan_sum : 0;//uzlashtirish summa

                        } else {
                            $son = '-';
                            $sum = '-';
                            $bartaraf_son = '-';
                            $bartaraf_sum = '-';
                            $uzlashtirilgan_son = '-';
                            $uzlashtirilgan_sum = '-';

                        }

                        echo "<td>" . $son . "</td>";
                        echo "<td>" . $sum . "</td>";
                        echo "<td>" . $bartaraf_son . "</td>";
                        echo "<td>" . $bartaraf_sum . "</td>";
                        echo "<td>" . $uzlashtirilgan_son . "</td>";
                        echo "<td>" . $uzlashtirilgan_sum . "</td>";
                    }


                    echo "</tr>";
                }


                ?>

            </table>


        </div>
    </div>

    <div class="body-content">

    </div>
</div>
