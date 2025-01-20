<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TekdanKeyinBartaraf $model */

$this->title = 'Create Tekdan Keyin Bartaraf';
$this->params['breadcrumbs'][] = ['label' => 'Tekdan Keyin Bartarafs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tekdan-keyin-bartaraf-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
