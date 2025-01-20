<?php

use app\models\TekdanKeyinBartaraf;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\TekdanKeyinBartarafSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tekdan Keyin Bartarafs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tekdan-keyin-bartaraf-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tekdan Keyin Bartaraf', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'farmoyish_id',
            'region_id',
            'branch_id',
            'mistake_id',
            //'file',
            //'departament_id',
            //'status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TekdanKeyinBartaraf $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
