<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\data\Mistakes $model */

$this->title = 'Update Mistakes: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mistakes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'code' => $model->code]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mistakes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
