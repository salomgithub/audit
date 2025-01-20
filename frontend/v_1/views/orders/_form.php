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
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput() ?>

    <?php
    $regions = Regions::find()->all();
    $regionItems = ArrayHelper::map($regions,'id','name');
    $regionParams = [
        'prompt' => 'Укажите область'
    ];

    $branchs = Branches::find()->all();
    $branchItems = ArrayHelper::map($branchs,'id','name');
    $branchParams = [
        'prompt' => 'Укажите МФО'
    ];


    ?>




    <?= $form->field($model, 'region_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'1']])->dropDownList(ArrayHelper::map(Regions::find()->all(),'id','name'),
        [
            'prompt'  => '....',
            'onchange'=> '
                $.post( "index.php?r=orders%2Flistbranches&id='.'"+$(this).val(), function (data){
                $("select#orders-branch_id").html(data);
            });'
        ]); ?>

    <?= $form->field($model, 'branch_id', ['inputOptions'=>['class' =>'form-control', 'tabindex'=>'2']])->dropDownList(ArrayHelper::map($branchs,'id','name'),
        [
            'prompt'  => '.......',
        ]); ?>

    <?= $form->field($model, 'file')->fileInput(['class' => 'btn btn-primary']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
