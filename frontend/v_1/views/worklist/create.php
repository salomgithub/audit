<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Worklist $model */

$this->title = 'Create Worklist';
$this->params['breadcrumbs'][] = ['label' => 'Worklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="worklist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'work' => $work,
    ]) ?>

</div>
