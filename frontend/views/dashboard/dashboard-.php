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

            $departaments = \app\models\data\Departaments::find()->all();
            foreach ($departaments as $departament) {
                $d0 = Work::find()->where(['work_status' => 0, 'departament_id' => $departament->id])->sum('mistake_sum');
                $d1 = Work::find()->where(['work_status' => 1, 'departament_id' => $departament->id])->sum('mistake_soni');
                $d2 = Work::find()->where(['work_status' => 2, 'departament_id' => $departament->id])->sum('mistake_soni');

                $all = (int)($d0 + $d1 + $d2);// Jami summasi
                if ($all >= 100000000) {
                    $a = (string)$departament->name;
                    $a = substr($a, 0, 10);
                    $dataPoints3[] = ["label" => $a, "symbol" => $departament->name, "y" => (int)$all];
                }
            }
            $dataPoints4 = array(
                array("label" => "summai", "y" => 36.12),
                array("label" => "20111", "y" => 34.87),
                array("label" => "20121", "y" => 40.30),
                array("label" => "20131", "y" => 35.30),
                array("label" => "2014", "y" => 39.50),
                array("label" => "2015", "y" => 50.82),
                array("label" => "20161", "y" => 74.70)
            );
            $dataPoints5 = array(
                array("label" => "sumaaaaaaaaaaaaaaaaaaaamasi", "y" => 64.61),
                array("label" => "summasi2", "y" => 70.55),
                array("label" => "2012", "y" => 72.50),
                array("label" => "2013", "y" => 81.30),
                array("label" => "20141", "y" => 63.60),
                array("label" => "2015", "y" => 69.38),
                array("label" => "2016", "y" => 98.70)
            );
            ?>
            <script>
                window.onload = function () {

                    var chart1 = new CanvasJS.Chart("chartContainer1", {
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
                    chart1.render();
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
                    var chart3 = new CanvasJS.Chart("chartContainer3", {
                        animationEnabled: true,
                        theme: "light2",
                        title: {
                            text: "Департаментлар бўйича статистика"
                        },
                        axisY: {
                            suffix: "%",
                            scaleBreaks: {
                                autoCalculate: true
                            }
                        },
                        data: [{
                            type: "column",
                            yValueFormatString: "#,##0\"\"",
                            indexLabel: "{y}",
                            indexLabelPlacement: "inside",
                            indexLabelFontColor: "white",
                            dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
                        }]
                    });
                    chart3.render();

                    var chart5 = new CanvasJS.Chart("chartContainer5", {
                        theme: "light2",
                        animationEnabled: true,
                        title: {
                            text: "Департаментлар бўйича камчиликлар суммаси мониторинги "
                        },
                        data: [{
                            type: "doughnut",
                            indexLabel: "{symbol} - {y}",
                            yValueFormatString: "#,##0.\"\"",
                            showInLegend: true,
                            legendText: "{label} : {y}",
                            dataPoints: <?php echo json_encode($dataPoints3, JSON_NUMERIC_CHECK); ?>
                        }]
                    });
                    chart5.render();

                    function toggleDataSeries(e) {
                        if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                            e.dataSeries.visible = false;
                        } else {
                            e.dataSeries.visible = true;
                        }
                        chart4.render();
                    }

                }
            </script>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div id="chartContainer3" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div id="chartContainer5" style="height: 370px; width: 100%;"></div>
                    </div>
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
