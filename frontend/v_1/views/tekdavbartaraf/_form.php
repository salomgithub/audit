<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TekDavBartaraf $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tek-dav-bartaraf-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'farmoish_id')->textInput() ?>

    <?= $form->field($model, 'region_id')->textInput() ?>

    <?= $form->field($model, 'branch_id')->textInput() ?>

    <?= $form->field($model, 'mistake_id')->textInput() ?>

    <?= $form->field($model, 'bartaraf_son')->textInput() ?>

    <?= $form->field($model, 'bartaraf_sum')->textInput() ?>

    <?= $form->field($model, 'file')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
