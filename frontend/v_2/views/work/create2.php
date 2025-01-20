<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Work $model */

$this->title = 'Joyida bartaraf qilingan kamchiliklarni kiritish ';
$this->params['breadcrumbs'][] = ['label' => 'Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_', [
        'model' => $model,
        'regions' => $regions,
        'branches' => $branches,
    ]) ?>

</div>
