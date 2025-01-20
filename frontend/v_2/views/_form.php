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
        <div class="col-md-3">
            <?= $form->field($model, 'year')->textInput(['value'=>2023]) ?>
            <?= $form->field($model, 'farmoyish_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'1']])->dropDownList(ArrayHelper::map(\app\models\data\Orders::find()->all(),'code','code'),
                [
                    'prompt'  => '.......',
                ]); ?>
            <?= $form->field($model, 'region_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'2']])->dropDownList(ArrayHelper::map($regions,'id','name'),
                [
                    'prompt'  => '.......',
                    'onchange'=> '
                $.post( "/my/listbranches?id='.'"+$(this).val(), function (data){
                $("select#work-branch_id").html(data);});'
                ]); ?>

            <?= $form->field($model, 'branch_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'3']])->dropDownList([],
                [
                    'prompt'  => '.......',
                ]); ?>

        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'head_mistakes_group_code', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'8']])->dropDownList(ArrayHelper::map(\app\models\data\HeadMistakesGroup::find()->all(),'code','name'),
                [
                    'prompt'  => '.......',
                    'onchange'=> '
                $.post( "/my/listheadmistakes?id='.'"+$(this).val(), function (data){
                    $("select#work-mistake_code").html(data);});'
                ]); ?>

            <?= $form->field($model, 'mistake_code', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'9']])->dropDownList([],
                [
                    'prompt'  => '.......',
                    'onchange'=> '
                $.post( "/my/listmistakes?id='.'"+$(this).val(), function (data){
                $("select#work-status").html(data);});'
                ]); ?>
            <?= $form->field($model, 'status', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'10']])->dropDownList([]); ?>
            <?= $form->field($model, 'mistake_soni', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'11']])->textInput() ?>
            <?= $form->field($model, 'mistake_sum', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'12']])->textInput() ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'unical', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'4']])->textInput() ?>
            <?= $form->field($model, 'client_name', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'5']])->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'mistak_from_user', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'6']])->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'departament_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'7']])->dropDownList(ArrayHelper::map(Departaments::find()->all(),'id','name'),[
                'prompt'  => '.......',
            ]); ?>
        </div>

        <div class="col-md-3">
            <?= $form->field($model, 'bartaraf_soni', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'13']])->textInput(['value'=>0]) ?>
            <?= $form->field($model, 'bartaraf_sum', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'14']])->textInput(['value'=>0]) ?>

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
