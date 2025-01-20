<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\EmployeeSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="aktive-search">

    <?php $form = ActiveForm::begin([
        'action' => ['kapital'],
        'method' => 'get',
        'options' => ['class' => 'form-inline'], // Make the form inline
    ]); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'from_data')->dropDownList($dropdownItems, [
                'prompt' => 'Select a date range', // Add a prompt for the dropdown
            ]) ?>
        </div>

        <div class="col-md-3"><br>
            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

