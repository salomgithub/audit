<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Balance $model */

$this->title = 'Update Balance: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Balances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="balance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
