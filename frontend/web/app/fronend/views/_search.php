<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\BalanceSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="balance-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'hisob_raqam') ?>

    <?= $form->field($model, 'hisob_raqam_nomi') ?>

    <?= $form->field($model, 'kirim_aktiv') ?>

    <?= $form->field($model, 'kirim_passiv') ?>

    <?php // echo $form->field($model, 'debet') ?>

    <?php // echo $form->field($model, 'kredit') ?>

    <?php // echo $form->field($model, 'chiqim_aktiv') ?>

    <?php // echo $form->field($model, 'chiqim_passiv') ?>

    <?php // echo $form->field($model, 'from_data') ?>

    <?php // echo $form->field($model, 'to_data') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
