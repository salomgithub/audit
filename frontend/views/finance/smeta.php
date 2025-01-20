<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
//echo $this->render('_search', ['model' => $searchModel]);
?>
<div class="row">
<h3 align="center">АТ "Халқ банк"нинг Фаргона вилояти Бешариқ филиали филиали томонидан олинган даромад ва қилинган харажатлар таҳлили, ҳамда сметасига амал қилиниши тўғрисида 2024 йил 1 январ ҳолатига</h3>

    <table class="table table-striped table-bordered" id="source-table">
        <tr>
            <th style="text-align: center;" width="40%" rowspan="2">Капитал таркиби</th>
            <th colspan="2">2023 йил 1 январ ҳолатига</th>
            <th colspan="2">2024 йил 1 январ ҳолатига</th>
            <th colspan="2" rowspan="2">фарқи (+;-)</th>
        </tr>
        <tr>
            <th>Сумма</th>
            <th>фоиз</th>
            <th>Сумма</th>
            <th>фоиз</th>
        </tr>
        <?php  foreach ($model as $items) {
            foreach ($items as $item) {
                echo "<tr>";
                $sanoq = 0;
                foreach ($item as $i) {
                    echo "<td>";
                    if ($sanoq>0 && $sanoq!=2 && $sanoq!=4){
                        $i = number_format((float)$i/1000, 1,'.', ' ');
                        if ($i==0.0){ $i = 0; }

                    }
                    if ($sanoq==2 || $sanoq==4){
                        $i = number_format($i, 1,'.', ' ');
                        if ($i==0.0){ $i = 0; }
                    }
                    echo $i;
                    echo "</td>";
                    $sanoq++;
                }
                echo "</tr>";
            }
        } ?>
    </table>
    <pre>
        <?
        var_dump($model);
        ?>
   </pre>
</div>


