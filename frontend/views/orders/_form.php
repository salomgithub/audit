<?php

use app\models\data\Branches;
use app\models\data\Orders;
use app\models\data\Regions;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\data\Orders $model */
/** @var yii\widgets\ActiveForm $form */
$regions = Regions::find()->all();
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput() ?>

    <?= $form->field($model, 'region_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'2']])->dropDownList(ArrayHelper::map($regions,'id','name'),
        [
            'prompt'  => 'Укажите область',
            'onchange'=> '
                $.post( "/my/listbranches2?id='.'"+$(this).val(), function (data){
                $("select#orders-branch_id").html(data);});'
        ]); ?>

    <?= $form->field($model, 'branch_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'3']])->dropDownList([],
        [
            'prompt'  => 'Укажите МФО',
        ]); ?>


    <?= $form->field($model, 'file')->fileInput(['class' => 'btn btn-primary']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сақлаш', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
