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
            <script>
                window.onload = function () {

                    var chart = new CanvasJS.Chart("chartContainer", {
                        theme: "light2",
                        animationEnabled: true,
                        title: {
                            text: "Kamchiliklar soni monitoringi"
                        },
                        data: [{
                            type: "doughnut",
                            indexLabel: "{symbol} - {y}",
                            yValueFormatString: "#,##0.\"\"",
                            showInLegend: true,
                            legendText: "{label} : {y}",
                            dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
                        }]
                    });
                    chart.render();
                    var chart2 = new CanvasJS.Chart("chartContainer2", {
                        theme: "light2",
                        animationEnabled: true,
                        title: {
                            text: "Kamchiliklar summasi monitoringi "
                        },
                        data: [{
                            type: "doughnut",
                            indexLabel: "{symbol} - {y}",
                            yValueFormatString: "#,##0.\"\"",
                            showInLegend: true,
                            legendText: "{label} : {y}",
                            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
                        }]
                    });
                    chart2.render();

                }
            </script>
            <div class="row">
                <div class="col-md-6">
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                </div>
                <div class="col-md-6">
                    <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
                </div>
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
                    <th colspan="4">Кредит амалиётлари бўйича камчиликлар</th>
                    <th colspan="4">Бухгалтерия амалиёти бўйича</th>
                    <th colspan="4">Чакана амалиётлар</th>
                    <th colspan="4">Банк карталари сектори</th>
                    <th colspan="4">Касса амалиётлари бўйича</th>
                    <th colspan="4">Узлаштириш</th>

                </tr>
                <tr>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>

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

                        } else {
                            $son = '-';
                            $sum = '-';
                            $bartaraf_son = '-';
                            $bartaraf_sum = '-';

                        }

                        echo "<td>" . $son . "</td>";
                        echo "<td>" . $sum . "</td>";
                        echo "<td>" . $bartaraf_son . "</td>";
                        echo "<td>" . $bartaraf_sum . "</td>";
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
