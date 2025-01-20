<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

?>
<?php
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/video.js/7.16.4/video.min.js', ['position' => View::POS_END]);
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/video.js/7.16.4/video-js.min.css');
$this->registerJsFile('@web/js/capture.js', ['position' => View::POS_END]);
?>

<div class="site-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-md-6">
            <video id="camera-preview" class="video-js vjs-default-skin"></video>
            <button id="take-photo-button" class="btn btn-primary">Take Photo</button>
        </div>
        <div class="col-md-6">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'captured_photo')->hiddenInput(['id' => 'captured-photo'])->label(false) ?>

            <?= $form->field($model, 'employee_id')->textInput() ?>

            <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
