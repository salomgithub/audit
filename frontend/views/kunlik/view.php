<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Kunlik $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Kunliks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kunlik-view">

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
            [
                'attribute'=>'user_id',
                'value'=> function($model){
                    $user_id = $model->user_id;
                    $fio = \common\models\User::findOne($user_id);
                    return $fio->fio;
                },
            ],
            'branch',
            'tek_mazmun:ntext',
            'kamchilik:ntext',
            'soni',
            'summa',
            'date_start',
            'create_at',
        ],
    ]) ?>

</div>
