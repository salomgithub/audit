<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\data\Quantity $model */

$this->title = 'Create Quantity';
$this->params['breadcrumbs'][] = ['label' => 'Quantities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quantity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
