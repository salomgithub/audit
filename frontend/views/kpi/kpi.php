<?php

/** @var yii\web\View $this */

use app\models\data\HeadMistakesGroup;
use app\models\Work;

$this->title = 'Hisobot';
$umumiy = Work::find()->count();
$departaments = \app\models\data\Departaments::find()->all();

echo $this->render('_search_kpi', ['model' => $searchModel]);
$user= \common\models\User::find()->select(['fio'])->all();
//print_r($user);
$dataPoints1 = [];
$dataPoints2 = [];
$dataPoints3 = [];

?><br>

<script>
    function exportExcel() {
        var table = document.getElementById("source-table");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(html);
        var link = document.createElement("a");
        link.href = url;
        link.download = "KPI.xls";
        link.click();
    }

</script>

<div class="site-index">
    <div class="  bg-transparent rounded-3">
        <div class="  text-center">
            <?php
            $this->registerJsFile("@web/js/canvasjs.min.js", [
                'depends' => [
                    \yii\web\JqueryAsset::className()
                ]
            ]);
            ?>
            <table class="table table-striped table-bordered" id="source-table">
                <tr>
                    <th rowspan="3" width="20%">Ф.И.О</th>
                    <?php $kpi = \app\models\Kpi::find()->all(); ?>
                    <?php foreach ($kpi as $kpiItem): ?>
                        <th colspan="2" width="10%"><?= $kpiItem->name ?></th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($kpi as $kpiItem): ?>
                        <th rowspan="2" width="10%">Сони</th>
                        <th rowspan="2" width="10%">Суммаси</th>
                    <?php endforeach; ?>
                </tr>
                <tr></tr>

                <?php
                foreach ($departamentsData as $departamentData) {
                    echo "<tr>";
                    echo "<td>" . $departamentData['name'] . "</td>";
                    $i = 1;
                    foreach ($departamentData['mistakes'] as $mistake) {

                        echo "<td>" . $mistake['son'] . "</td>";
                        echo "<td>" . ((float)$mistake['sum'] == 0 ? "-" : number_format((float)$mistake['sum'])) . "</td>";

                        $y = ((int)$mistake['sum']);
                        if ($y == '-') $y = 1;
                        if($i == 1 && $y > 1){
                            $dataPoints1[] = ["label" => $departamentData['name'], "symbol" => $departamentData['name'], "y" => $y];
                        }
                        if($i == 2 && $y > 1){
                            $dataPoints2[] = ["label" => $departamentData['name'], "symbol" => $departamentData['name'], "y" => $y];
                        }
                        if($i == 3 && $y > 1){
                            $dataPoints3[] = ["label" => $departamentData['name'], "symbol" => $departamentData['name'], "y" => $y];
                        }
                        $i++;
                    }
                    echo "</tr>";
                }

                ?>
            </table>
        </div>
    </div>
    <div class="body-content">

        <script>
            window.onload = function () {
                var chart1 = new CanvasJS.Chart("chartContainer1", {
                    animationEnabled: true,
                    theme: "light2",
                    title: {
                        text: "Ходимлар бўйича KPI(Ўзлаштириш) статистика"
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
                        dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart1.render();

                var chart2 = new CanvasJS.Chart("chartContainer2", {
                    animationEnabled: true,
                    theme: "light2",
                    title: {
                        text: "Ходимлар бўйича KPI(Мақсадсиз) статистика"
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
                        dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
                    }]
                });
                chart2.render();

                var chart3 = new CanvasJS.Chart("chartContainer3", {
                    animationEnabled: true,
                    theme: "light2",
                    title: {
                        text: "Ходимлар бўйича KPI(Даромад) статистика"
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

                function toggleDataSeries(e){
                    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    }
                    else{
                        e.dataSeries.visible = true;
                    }
                    chart4.render();
                }

            }
        </script>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div id="chartContainer3" style="height: 370px; width: 100%;"></div>
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
