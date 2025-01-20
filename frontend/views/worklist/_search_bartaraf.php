<?php

use app\models\data\Branches;
use app\models\data\Regions;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\data\OrdersSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['list'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'year') ?>
        </div>

        <div class="col-md-2">
            <?php


            $regions = ArrayHelper::map(Regions::find()->andFilterWhere( ['id'=>$model->region_id] )->all(), 'id', 'name');
            ?>
            <?= $form->field($model, 'region_id', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '2']])->dropDownList([$regions],
            [
            'prompt' => '.......',
            'onchange' => '
                $.post( "/my/listbranches?id=' . '"+$(this).val(), function (data){
                $("select#worksearch-branch_id").html(data);});'
            ]); ?>
        </div>
        <div class="col-md-2">
            <?php
            $branch = ArrayHelper::map(Branches::find()->where(['region_id' => $model->region_id])->all(), 'id', 'name');
            ?>
            <?= $form->field($model, 'branch_id', ['inputOptions' => ['class' => 'form-control', 'tabindex' => '3']])->dropDownList([$branch],
            ['prompt' => '.......',]); ?>
        </div>

        <div class="col-md-3">
            <div class="form-group"><br>
                <button  class="btn btn-primary">
                    <i class="bi bi-search"></i>
                </button>
                <?= Html::resetButton('', ['onclick' => 'exportExcel()', 'class' => 'btn btn-success bi bi-file-earmark-spreadsheet-fill']) ?>
                <?= Html::a("Сброс", 'list', ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>
