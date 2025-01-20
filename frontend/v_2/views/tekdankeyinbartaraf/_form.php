<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TekdanKeyinBartaraf $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tekdan-keyin-bartaraf-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'farmoyish_id')->textInput() ?>

    <?= $form->field($model, 'region_id')->textInput() ?>

    <?= $form->field($model, 'branch_id')->textInput() ?>

    <?= $form->field($model, 'mistake_id')->textInput() ?>

    <?= $form->field($model, 'file')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'departament_id')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
