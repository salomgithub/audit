<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Balance $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="balance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'hisob_raqam')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hisob_raqam_nomi')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kirim_aktiv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kirim_passiv')->textInput() ?>

    <?= $form->field($model, 'debet')->textInput() ?>

    <?= $form->field($model, 'kredit')->textInput() ?>

    <?= $form->field($model, 'chiqim_aktiv')->textInput() ?>

    <?= $form->field($model, 'chiqim_passiv')->textInput() ?>

    <?= $form->field($model, 'from_data')->textInput() ?>

    <?= $form->field($model, 'to_data')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
