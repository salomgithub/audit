<?php

/** @var yii\web\View $this */

use app\models\data\HeadMistakesGroup;
use app\models\Work;

$this->title = 'Hisobot';
$umumiy = Work::find()->count();
$departaments = \app\models\data\Departaments::find()->all();
echo $this->render('_search', ['model' => $searchModel]);
?>
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
<br>
<div class="site-index">
    <div class="  bg-transparent rounded-3">
        <div class="  text-center">
            <table class="table table-striped table-bordered" id="source-table">
                <tr>
                    <th rowspan="3">Таркибий бўлинмалар номи</th>
                    <th colspan="4">Кредит амалиётлари бўйича камчиликлар</th>
                    <th colspan="4">Бухгалтерия амалиёти бўйича</th>
                    <th colspan="4">Чакана амалиётлар</th>
                    <th colspan="4">Банк карталари сектори</th>
                    <th colspan="4">Касса амалиётлари бўйича</th>
                    <!--                    <th colspan="4">Узлаштириш</th>-->

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
                    <!--                    <th rowspan="2">Сони</th>-->
                    <!--                    <th rowspan="2">Суммаси</th>-->
                    <!--                    <th colspan="2">Шундан бартараф қилинди</th>-->

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
                    <!--                    <th>Сони</th>-->
                    <!--                    <th>Суммаси</th>-->
                </tr>

                <?php
                foreach ($departamentsData as $departamentData) {
                    echo "<tr>";
                    echo "<td>" . $departamentData['name'] . "</td>";
                    foreach ($departamentData['mistakes'] as $mistake) {
                        echo "<td>" . $mistake['son'] . "</td>";
                        echo "<td>" . ((float)$mistake['sum'] == 0 ? "-" : number_format((float)$mistake['sum'])) . "</td>";
                        echo "<td>" . $mistake['bartaraf_son'] . "</td>";
                        echo "<td>" . $mistake['bartaraf_sum'] . "</td>";
                    }
                    echo "</tr>";
                }

                ?>

            </table>

        </div>
    </div>

    <div class="body-content">
        <pre>
        </pre>

    </div>
</div>
