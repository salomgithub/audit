<?php

/** @var yii\web\View $this */

use app\models\data\HeadMistakesGroup;
use app\models\Work;

$this->title = 'Hisobot';
$umumiy = Work::find()->count();
$departaments = \app\models\data\Departaments::find()->all();
echo $this->render('_search_uzlashtirish', ['model' => $searchModel]);

?><br>
<script>
    function exportExcel() {
        var table = document.getElementById("source-table");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(html);
        var link = document.createElement("a");
        link.href = url;
        link.download = "table.xls";
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
                    <th rowspan="3">Таркибий бўлинмалар номи</th>
                    <th colspan="2">Кредит амалиётлари бўйича камчиликлар</th>
                    <th colspan="2">Бухгалтерия амалиёти бўйича</th>
                    <th colspan="2">Чакана амалиётлар</th>
                    <th colspan="2">Банк карталари сектори</th>
                    <th colspan="2">Касса амалиётлари бўйича</th>
                </tr>
                <tr>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                </tr>
                <tr></tr>

                <?php
                foreach ($departamentsData as $departamentData) {
                    echo "<tr>";
                    echo "<td>" . $departamentData['name'] . "</td>";
                    foreach ($departamentData['mistakes'] as $mistake) {
                        echo "<td>" . $mistake['son'] . "</td>";
                        echo "<td>" . ((float)$mistake['sum'] == 0 ? "-" : number_format((float)$mistake['sum'])) . "</td>";

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
