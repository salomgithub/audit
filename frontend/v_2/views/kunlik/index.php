<?php

use app\models\Kunlik;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\KunlikSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kunliks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kunlik-index">

    <h1>Kunlik bajariladigann ishlar monitoringi</h1>

    <p>
        <?= Html::a('Kunlik ishni kiritish', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'user_id',
            [
                'attribute'=>'user_id',
                'value'=> function($model){
                    $user_id = $model->user_id;
                    $fio = \common\models\User::findOne($user_id);
                    return $fio->fio??"-";
                },
            ],
            'branch',
            'tek_mazmun:ntext',
            'kamchilik:ntext',
            [
                'attribute' => 'date_start',
                'filter' => \yii\jui\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_start',
                    'language' => 'en',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
                ]),
//                'format' => 'datetime',
            ],
            //'soni',
            //'summa',
//            'date_start',
//            'create_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Kunlik $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
