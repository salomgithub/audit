<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Worklist $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Worklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="worklist-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'work_id',
            'file',
            'commet',
//            'status',
            [
                'attribute'=>'status',
                'format' => 'raw',
                'filter' => [
                    0 => 'Yangi',
                    1 => 'Jarayonda',
                    2 => 'Yopilgan',
                    3 => 'Tekshiruv vaqtida bartaraf',
                ],
                'value' => function ($model) {
                    $work_status = $model->status;
                    if ($work_status == 0)
                        return Html::a('Yangi','#', ['class' => 'btn btn-danger']) ;
                    if ($work_status == 1)
                        return Html::a('Jarayonda','#', ['class' => 'btn btn-warning']) ;
                    if ($work_status == 3)
                        return Html::a('Tekshiruv vaqtida bartaraf','#', ['class' => 'btn btn-info']) ;
                    else return Html::a('Yopilgan', '#',['class' => 'btn btn-primary']) ;
                },
            ],
        ],
    ]) ?>

</div>
