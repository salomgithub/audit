<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\EmployeeSearch $model */
/** @var yii\widgets\ActiveForm $form */
$regions = \app\models\data\Regions::find()->all();
?>

<div class="aktive-search">

    <?php $form = ActiveForm::begin([
        'action' => ['aktivlar'],
        'method' => 'get',
        'options' => ['class' => 'form-inline'], // Make the form inline
    ]); ?>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'region_id', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '3']])->dropDownList(ArrayHelper::map($regions, 'id', 'name'),
                [
                    'prompt' => '.......',
                    'onchange' => '
                $.post( "/my/listbranches?id=' . '"+$(this).val(), function (data){
                $("select#balancesearch-branch_id").html(data);});'
                ]); ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'branch_id', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '4']])->dropDownList([],
                [
                    'prompt' => '.......',
                ]); ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'from_data')->dropDownList($dropdownItems, [
                'prompt' => 'vaqt oraligini tanlang', // Add a prompt for the dropdown
            ]) ?>
        </div>

        <div class="col-md-3"><br>
            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

