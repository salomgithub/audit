<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\data\OrdersSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['akt'],
        'method' => 'get',
    ]); ?>
<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'farmoyish_id') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'region_id') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'year') ?>
    </div>
    <div class="col-md-3">
        <div class="form-group"><br>
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>
    </div>

</div>








    <?php ActiveForm::end(); ?>

</div>
