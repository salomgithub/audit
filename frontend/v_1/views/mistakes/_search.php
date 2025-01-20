<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\data\MistakesSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mistakes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'quantity') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'create_at') ?>

    <?php // echo $form->field($model, 'head_mistakes_group_code') ?>

    <?php // echo $form->field($model, 'mistakes_group_code') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
