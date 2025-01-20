<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Kunlik $model */

$this->title = 'Update Kunlik: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kunliks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kunlik-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
