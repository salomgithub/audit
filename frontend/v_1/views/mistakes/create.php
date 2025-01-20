<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\data\Mistakes $model */

$this->title = 'Create Mistakes';
$this->params['breadcrumbs'][] = ['label' => 'Mistakes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mistakes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
