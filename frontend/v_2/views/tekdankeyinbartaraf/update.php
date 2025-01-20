<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TekdanKeyinBartaraf $model */

$this->title = 'Update Tekdan Keyin Bartaraf: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tekdan Keyin Bartarafs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tekdan-keyin-bartaraf-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
