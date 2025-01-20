<?php

use app\models\TekDavBartaraf;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\TekDavBartarafSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tek Dav Bartarafs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tek-dav-bartaraf-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tek Dav Bartaraf', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'farmoish_id',
            'region_id',
            'branch_id',
            'mistake_id',
            //'bartaraf_son',
            //'bartaraf_sum',
            //'file',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TekDavBartaraf $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
