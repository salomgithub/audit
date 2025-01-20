<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\data\Quantity $model */

$this->title = 'Update Quantity: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Quantities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quantity-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
