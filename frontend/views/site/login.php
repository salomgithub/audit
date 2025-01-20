<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">


    <div class="row">

        <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div style="background-color: hsla(0,0%,100%,.9); padding: 5px 20px 50px 5px"
                         class="col-lg-3 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <?= Html::img('/img/xb-gold.png', ['alt' => 'Logo', 'width' => '255', 'height' => '80']) ?>

                        </div><h2 align="center" style="color: darkred">ATMT </h2>
                        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Логин') ?>

                        <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>


                        <div class="form-group" align="right">
                            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
    </div>
</div>
</div>
<!---->