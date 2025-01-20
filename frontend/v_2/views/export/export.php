<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ActiveField;

$this->title = 'Export Data to Excel';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="export-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'data_start')->textInput(['type' => 'date']) ?>
    <?= $form->field($model, 'data_end')->textInput(['type' => 'date']) ?>

    <div class="form-group">
        <?= Html::submitButton('Export to Excel', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>