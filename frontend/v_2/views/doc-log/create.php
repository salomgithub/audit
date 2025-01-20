<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\DocLog $model */

$this->title = 'Create Doc Log';
$this->params['breadcrumbs'][] = ['label' => 'Doc Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-log-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
