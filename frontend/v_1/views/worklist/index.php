<?php

//use app\models\Worklist;
use app\models\Xabar;
use frontend\models\Worklist;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use kartik\export\ExportMenu;

/** @var yii\web\View $this */
/** @var app\models\WorklistSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Bartaraf qilingan kamchiliklar tarixi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="worklist-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    $columns = [
        ['class' => 'yii\grid\SerialColumn'],

        'id',
        'work_id',
        'file',
        [
            'attribute' => 'Fayl',
            'format' => 'raw',
            //                'filter'=>\yii\helpers\ArrayHelper::map(\app\models\data\Regions::find()->all(),'id','name'),
            'value' => function ($model) {
                $yuklash = $model->file;
                return Html::a('Скачать', ['worklist/download', 'id' => $model->work_id], ['class' => 'btn btn-success']);
            },
        ],
        'commet',
//        'status',
        [
            'attribute'=>'status',
            'format' => 'raw',
            'filter' => [
                0 => 'Jarayonda',
                1 => 'Yopilgan',
            ],
            'value' => function ($model) {
                $status = $model->status;
                if ($status == 1)
                    return Html::a('Jarayonda',['edit','id'=>$model->work_id], ['class' => 'btn btn-warning']) ;
                if ($status == 2)
                    return Html::a('Yoligan','#', ['class' => 'btn btn-primary']) ;
                if ($status == 4)
                    return Html::a('Rad qilingan',['edit','id'=>$model->work_id], ['class' => 'btn btn-danger']) ;
                else return Html::a('Nomalum', '#',['class' => 'btn btn-primary']) ;
            },
        ],
        [
            'attribute'=>'Xabar',
            'value' => function ($model) {
                $status = $model->status;
                if ($status == 1){
                    $xabar = Xabar::find()
                        ->where(array('work_id' => $model->work_id))
                        ->orderBy(array('id' => SORT_DESC)) // San'atlarni ketma-ketlik bo'yicha tartiblash
                        ->one();
                    if (isset($xabar->xabar))
                    return $xabar->xabar;
                    return '';
                }
                else return '';
            },
        ],
        'created_at',

    ];


    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns, // Gridning ustunlari
    ]);;

 ?>


</div>
