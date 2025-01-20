<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Kunlik $model */

$this->title = 'Kunlik ishlarni kiritish';
$this->params['breadcrumbs'][] = ['label' => 'Kunliks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kunlik-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
