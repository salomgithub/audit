<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\data\OrdersSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
<div class="row">
    <div class="col-md-2">
        <?= $form->field($model, 'year') ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'farmoyish_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'1']])->dropDownList(ArrayHelper::map(\app\models\data\Orders::find()->all(),'code','code'),
            [
                'prompt'  => '.......',
            ]); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'region_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'2']])->dropDownList(ArrayHelper::map(\app\models\data\Regions::find()->all(),'id','name'),
            [
                'prompt'  => '.......',
                'onchange'=> '
                $.post( "/my/listbranches?id='.'"+$(this).val(), function (data){
                $("select#worksearch-branch_id").html(data);});'
            ]); ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'branch_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'3']])->dropDownList([],
            [
                'prompt'  => '.......',
            ]); ?>
    </div>

    <div class="col-md-3">
        <div class="form-group"><br>
            <?= Html::submitButton('Qidirish', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Tozalash', ['class' => 'btn btn-outline-secondary']) ?>
            <?= Html::resetButton('Yuklab olish', ['onclick' => 'exportExcel()','class' => 'btn btn-success']) ?>
        </div>
    </div>

</div>








    <?php ActiveForm::end(); ?>

</div>
