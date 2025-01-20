<?php

use app\models\data\Departaments;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Work $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="work-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'year')->textInput(['value'=>2024]) ?>
            <?= $form->field($model, 'farmoyish_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'2']])->dropDownList(ArrayHelper::map(\app\models\data\Orders::find()->all(),'code','code'),
                [
                    'prompt'  => '.......',
                    'onchange' => '
                $.post( "/my/listregions?id=' . '"+$(this).val(), function (data){
                $("select#work-region_id").html(data);});
                $.post( "/my/listbranchesfromorders?id=' . '"+$(this).val(), function (data){
                $("select#work-branch_id").html(data);});
                '
                ]); ?>
            <?= $form->field($model, 'region_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'3']])->dropDownList(ArrayHelper::map($regions,'id','name'),
                [
                    'prompt'  => '.......',
                    'onchange'=> '
                $.post( "/my/listbranches?id='.'"+$(this).val(), function (data){
                $("select#work-branch_id").html(data);});'
                ]); ?>

            <?= $form->field($model, 'branch_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'4']])->dropDownList([],
                [
                    'prompt'  => '.......',
                ]); ?>

        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-5">
                    <?= $form->field($model, 'head_mistakes_group_code', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'5']])->dropDownList(ArrayHelper::map(\app\models\data\HeadMistakesGroup::find()->all(),'code','name'),
                        [
                            'prompt'  => '.......',
                            'onchange'=> '
                $.post( "/my/listheadmistakes?id='.'"+$(this).val(), function (data){
                    $("select#work-mistake_code").html(data); 
                    var a = document.getElementById("work-head_mistakes_group_code").value;
                    if (a === "1000") {
                        document.getElementById("work-unical").style.display = "block";
                        document.getElementById("label-unical").style.display = "block";
                        document.getElementById("work-hisob_raqam").style.display = "none";
                        document.getElementById("label-hisob_raqam").style.display = "none";
                    }else {
                        document.getElementById("work-unical").style.display = "none";
                        document.getElementById("label-unical").style.display = "none";
                        document.getElementById("work-hisob_raqam").style.display = "block";
                        document.getElementById("label-hisob_raqam").style.display = "block";
                    }
                    
                    });
                    $.post( "/my/listmistakesfromgroup?id='.'"+$(this).val(), function (data){
                    $("select#work-mistake-group").html(data); 
                    var a = document.getElementById("work-head_mistakes_group_code").value;
                    
                    
                    });
                    '
                        ]); ?>
                </div>
                <div class="col-md-7">
                    <label for="Work[group]">Тур</label>
                    <select id="work-mistake-group" class="form-control" name="Work[group]" tabindex="6" aria-required="true"
                            onchange="$.post('/my/listgroupmistakes?id=' + $(this).val(), function(data){ $('#work-mistake_code').html(data);
                    });">
                        <option>----</option>
                    </select>
                </div>
            </div>


            <?= $form->field($model, 'mistake_code', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'7']])->listBox([],
                [
                    'prompt'  => '.......',
                    'multiple' => true,
                    'size'=>10,
                    'onchange'=> '
                $.post( "/my/listmistakes?id='.'"+$(this).val(), function (data){
                $("select#work-status").html(data);
               
                });
                $.post( "/my/listqiymat?id='.'"+$(this).val(), function (data1){
                    if (data1 === "1") {
                        document.getElementById("work-mistake_sum").style.display = "block";
                        document.getElementById("label-mistake_sum").style.display = "block";
                        document.getElementById("work-bartaraf_sum").style.display = "block";
                        document.getElementById("label-work-bartaraf_sum").style.display = "block";
                        document.getElementById("work-hisob_raqam").style.display = "block";
                        document.getElementById("label-hisob_raqam").style.display = "block";

                    }if (data1 === "2") {
                        document.getElementById("work-hisob_raqam").style.display = "none";
                        document.getElementById("label-hisob_raqam").style.display = "none";
                        document.getElementById("work-bartaraf_sum").style.display = "none";
                        document.getElementById("label-work-bartaraf_sum").style.display = "none";

                    }else {
                        //document.getElementById("work-mistake_sum").style.display = "none";
                        //document.getElementById("label-mistake_sum").style.display = "none";
                    }
                console.log(data1);});
                '
                ]); ?>

        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'mistake_soni', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'8', 'type' => 'number']])->textInput() ?>
            <label id="label-mistake_sum" class="control-label" ">Kamchilik summasi</label>
            <?= $form->field($model, 'mistake_sum', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'9', 'type' => 'number']])->textInput()->label(false) ?>
            <label id="label-unical" class="control-label" style="display:none;">Kdredit ID</label>
            <?= $form->field($model, 'unical', ['inputOptions'=>['class' =>'form-control', 'style'=>'display:none', 'tabindex'=>'10']])->textInput()->label(false) ?>
            <label id="label-hisob_raqam" class="control-label" style="display:none;">Hisob raqam</label>
            <?= $form->field($model, 'hisob_raqam', ['inputOptions'=>['class' =>'form-control', 'style'=>'display:none', 'tabindex'=>'11']])->textInput()->label(false) ?>
            <?= $form->field($model, 'client_name', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'12']])->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'mistak_from_user', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'13']])->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'departament_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'14']])->dropDownList(ArrayHelper::map(Departaments::find()->all(),'id','name'),[
                'prompt'  => '.......',
            ]); ?>
        </div>



    </div>
    <?= $form->field($model, 'comment', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'15']])->textarea(['rows' => 3]) ?>

    <br>
    <div class="form-group">
        <?= Html::submitButton('Saqlash', ['class' => 'btn btn-success ']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$js = <<< JS
const numberInput = document.getElementById("numberInput");

numberInput.addEventListener("input", function () {
    const value = this.value.replace(/\D/g, "");
    const formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    this.value = formattedValue;
});
JS;
$this->registerJs($js);
?>