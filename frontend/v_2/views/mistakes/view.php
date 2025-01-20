<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\data\Mistakes $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mistakes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="mistakes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'code' => $model->code], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'code' => $model->code], [
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
            'code',
            'name',
            'quantity',
            'status',
            'create_at',
            'head_mistakes_group_code',
            'mistakes_group_code',
        ],
    ]) ?>

</div>
