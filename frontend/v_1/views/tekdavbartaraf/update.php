<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TekDavBartaraf $model */

$this->title = 'Update Tek Dav Bartaraf: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tek Dav Bartarafs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tek-dav-bartaraf-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
