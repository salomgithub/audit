<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Balance $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Balances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="balance-view">

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
            'hisob_raqam',
            'hisob_raqam_nomi:ntext',
            'kirim_aktiv',
            'kirim_passiv',
            'debet',
            'kredit',
            'chiqim_aktiv',
            'chiqim_passiv',
            'from_data',
            'to_data',
        ],
    ]) ?>

</div>
