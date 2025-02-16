<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

echo $this->render('_search', [
    'model' => $searchModel,
    'dropdownItems' => $dropdownItems
]);

?>
<div class="row">
    <h3 align="center"> АТ "Халқ банк"нинг Фаргона вилояти Бешариқ филиали бўйича <?= $to_data ?> ҳолатига активлар
        ТАҲЛИЛИ</h3>

    <table class="table table-striped table-bordered" id="source-table">
        <tr>
            <th style="text-align: center;" rowspan="2">Активлар таркиби</th>
            <th colspan="2"><?= $from_data ?> ҳолатига</th>
            <th colspan="2"><?= $to_data ?> ҳолатига</th>
            <th colspan="2" rowspan="2">фарқи (+;-)</th>
        </tr>
        <tr>
            <th>Сумма</th>
            <th>фоиз</th>
            <th>Сумма</th>
            <th>фоиз</th>
        </tr>
        <?php
        if (is_array($model)) {
            foreach ($model as $items) {
                foreach ($items as $item) {
                    echo "<tr>";
                    $sanoq = 0;
                    foreach ($item as $i) {
                        echo "<td>";
                        if ($sanoq > 0 && $sanoq != 2 && $sanoq != 4) {
                            $i = number_format((float)$i / 1000, 1, '.', ' ');
                            if ($i == 0.0) {
                                $i = 0;
                            }

                        }
                        if ($sanoq == 2 || $sanoq == 4) {
                            $i = number_format($i, 1, '.', ' ');
                            if ($i == 0.0) {
                                $i = 0;
                            }
                        }
                        echo $i;
                        echo "</td>";
                        $sanoq++;
                    }
                    echo "</tr>";
                }
            }
        }?>
    </table>

</div>


