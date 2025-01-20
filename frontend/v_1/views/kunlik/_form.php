<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Kunlik $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kunlik-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'branch')->textInput() ?>

    <?= $form->field($model, 'tek_mazmun')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'kamchilik')->textarea(['rows' => 6]) ?>

    <div class="row ">
        <div class="col-md-2">
            <?= $form->field($model, 'soni')->textInput() ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'summa')->textInput() ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'date_start')->textInput(['type' => 'date', 'style' => 'width: 200px']) ?>
        </div>
        <div class="col-md-2">
            <div class="form-group"><br>
                <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>
