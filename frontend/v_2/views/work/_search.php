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

        <div class="col-md-1">
            <?= $form->field($model, 'start_data')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter date ...', 'class' => 'form-control'],
                'dateFormat' => 'php:Y-m-d',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'MM d, yyyy',
                    'todayHighlight' => true,
                ],
            ])->label(''); ?>
        </div>
        <div class="col-md-1">
            <?= $form->field($model, 'end_data')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Enter date ...', 'class' => 'form-control'],
                'dateFormat' => 'php:Y-m-d',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'MM d, yyyy',
                    'todayHighlight' => true,
                ],
            ])->label(''); ?>
        </div>


        <div class="col-md-3">
            <div class="form-group"><br>
                <?= Html::submitButton('Qidirish', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Tozalash', ['class' => 'btn btn-outline-secondary']) ?>
                <?= Html::resetButton('Yuklab olish', ['onclick' => 'exportExcel()', 'class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="col-md-6"></div>
        <div class="col-md-1">
            <?= $form->field($model, 'perPage')->dropDownList([
                20 => 20,
                50 => 50,
                100 => 100,
            ], ['prompt' => 'Select'])->label('') ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
