<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Worklist $model */

$this->title = 'Update Worklist: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Worklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="worklist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'work' => $work,
    ]) ?>

</div>
