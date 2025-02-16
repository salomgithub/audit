<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\EmployeeSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="employee-search">

    <?php $form = ActiveForm::begin([
        'action' => ['aktivlar'],
        'method' => 'post',
    ]); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'branch_id') ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'from_data')->textInput(['type' => 'date', 'style' => 'width: 90%']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'to_data')->textInput(['type' => 'date', 'style' => 'width: 90%']) ?>
        </div>
        <div class="col-md-3">
            <div class="form-group"><br>
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
        <br><br><br><hr>
    </div>
