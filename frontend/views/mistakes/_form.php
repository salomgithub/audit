<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\data\Mistakes $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="mistakes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity')->dropDownList(['1'=>'суммада','2'=>'сонда']) ?>

    <?= $form->field($model, 'status')->dropDownList(['1'=>'Енгил','2'=>'ўрта','3'=>'Оғир']) ?>

    <?= $form->field($model, 'head_mistakes_group_code', ['inputOptions'=>['class' =>'form-control']])->dropDownList(ArrayHelper::map(\app\models\data\HeadMistakesGroup::find()->all(),'code','name'),
                        [
                            'prompt'  => '.......',
                            'onchange'=> '
                    $.post( "/my/listmistakesfromgroup?id='.'"+$(this).val(), function (data){
                    $("select#mistakes-mistakes_group_code").html(data);                    
                    });
                    '
                        ]); ?>

    <?= $form->field($model, 'mistakes_group_code')->dropDownList([]) ?>

    <?= $form->field($model, 'uzlashtirish')->dropDownList(['0'=>'0','1'=>'Ўзлаштириш','2'=>'Мақсадсиз','3'=>'Даромад']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
