<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<?php  echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="row">

    <table class="table table-striped table-bordered" id="source-table">
        <tr>
            <th style="text-align: center;" rowspan="2">Активлар таркиби</th>
            <th colspan="2">_________ ҳолатига</th>
            <th colspan="2">_________ ҳолатига</th>
            <th colspan="2" rowspan="2">фарқи (+;-)</th>
        </tr>
        <tr>
            <th>Сумма</th>
            <th>фоиз</th>
            <th>Сумма</th>
            <th>фоиз</th>
        </tr>

    </table>

</div>


