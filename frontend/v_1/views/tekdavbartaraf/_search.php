<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\TekDavBartarafSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tek-dav-bartaraf-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'farmoish_id') ?>

    <?= $form->field($model, 'region_id') ?>

    <?= $form->field($model, 'branch_id') ?>

    <?= $form->field($model, 'mistake_id') ?>

    <?php // echo $form->field($model, 'bartaraf_son') ?>

    <?php // echo $form->field($model, 'bartaraf_sum') ?>

    <?php // echo $form->field($model, 'file') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
