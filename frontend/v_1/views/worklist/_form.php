<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Worklist $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="worklist-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-7">
            <?= $form->field($model, 'work_id')->textInput(['maxlength' => true, 'value' => $id, 'readonly' => true]) ?>
        </div>
        <div class="col-md-7">
            <?= $form->field($model, 'commet')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">

        </div>
        <div class="col-md-7">
            <?= $form->field($model, 'file')->fileInput(['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Yuborish', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
