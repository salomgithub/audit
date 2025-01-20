<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="tek-dav-bartaraf-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'farmoyish_id')->textInput() ?>

    <?= $form->field($model, 'region_id')->textInput() ?>

    <?= $form->field($model, 'branch_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
