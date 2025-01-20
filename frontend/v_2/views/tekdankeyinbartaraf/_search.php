<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\TekdanKeyinBartarafSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tekdan-keyin-bartaraf-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'farmoyish_id') ?>

    <?= $form->field($model, 'region_id') ?>

    <?= $form->field($model, 'branch_id') ?>

    <?= $form->field($model, 'mistake_id') ?>

    <?php // echo $form->field($model, 'file') ?>

    <?php // echo $form->field($model, 'departament_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
