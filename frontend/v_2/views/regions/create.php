<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\data\Regions $model */

$this->title = 'Create Regions';
$this->params['breadcrumbs'][] = ['label' => 'Regions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
