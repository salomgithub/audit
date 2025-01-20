<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
?>
<div class="row">
    <div class="col-md-3">
        <?php
        echo $form->field($model, 'file')->fileInput()->label('');
        ?>
    </div>
    <div class="col-md-3">
        <p></p>
        <?php
        echo Html::submitButton('Bazaga kiritish', ['class' => 'btn btn-primary']);
        ActiveForm::end();
        ?>
    </div>

</div>


