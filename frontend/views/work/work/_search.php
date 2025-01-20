<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;


/** @var yii\web\View $this */
/** @var app\models\search\WorkSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="work-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'start_data')->textInput(['type' => 'date', 'style' => 'width: 250px'])->label(false) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'end_data')->textInput(['type' => 'date', 'style' => 'width: 250px'])->label(false) ?>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <button  class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
                <button onclick="exportExcel()" class="btn btn-success">
                    <i class="bi bi-download"></i>
                </button>

            </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-1">
            <?= $form->field($model, 'perPage')->dropDownList([
                20 => 20,
                50 => 50,
                100 => 100,
            ], ['prompt' => 'выбор'])->label('') ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
