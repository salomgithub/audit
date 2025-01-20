<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TekdanKeyinBartaraf $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tekdan Keyin Bartarafs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tekdan-keyin-bartaraf-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'farmoyish_id',
            'region_id',
            'branch_id',
            'mistake_id',
            'file',
            'departament_id',
            'status',
        ],
    ]) ?>

</div>
