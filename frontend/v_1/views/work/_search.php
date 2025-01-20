<?php

use yii\helpers\Html;
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

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'farmoyish_id') ?>

    <?= $form->field($model, 'region_id') ?>

    <?= $form->field($model, 'branch_id') ?>

    <?= $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'unical') ?>

    <?php // echo $form->field($model, 'client_name') ?>

    <?php // echo $form->field($model, 'head_mistakes_group_code') ?>

    <?php // echo $form->field($model, 'mistake_code') ?>

    <?php // echo $form->field($model, 'mistake_soni') ?>

    <?php // echo $form->field($model, 'mistake_sum') ?>

    <?php // echo $form->field($model, 'mistak_from_user') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'departament_id') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
