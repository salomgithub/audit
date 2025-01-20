<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TekDavBartaraf $model */

$this->title = 'Create Tek Dav Bartaraf';
$this->params['breadcrumbs'][] = ['label' => 'Tek Dav Bartarafs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tek-dav-bartaraf-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
