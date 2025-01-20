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
            </div> <!--diagramma-->

            <?php
            $this->registerJsFile("@web/js/canvasjs.min.js", [
                'depends' => [
                    \yii\web\JqueryAsset::className()
                ]
            ]);
            ?>
        </div>
    </div>

    <div class="body-content">

    </div>
</div>
