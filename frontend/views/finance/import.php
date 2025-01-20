<?php

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);
?>
<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, 'region_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'3']])->dropDownList(ArrayHelper::map($regions,'id','name'),
            [
                'prompt'  => '.......',
                'onchange'=> '
                $.post( "/my/listbranches?id='.'"+$(this).val(), function (data){
                $("select#codeform-branch_id").html(data);});'
            ]); ?>

        <?= $form->field($model, 'branch_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'4']])->dropDownList([],
            [
                'prompt'  => '.......',
            ]); ?>
        <?= $form->field($model, 'file')->fileInput()->label('') ?>
    </div>
    <div class="col-md-3">
        <p></p>
        <?php
        echo Html::submitButton('Bazaga kiritish', ['class' => 'btn btn-primary']);
        ActiveForm::end();
        ?>
    </div>

</div>


