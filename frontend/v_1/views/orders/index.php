<?php

use app\models\data\Orders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\data\OrdersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Farmoyishlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Yangi farmoyish qo\'shish', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'code',
//            'name',
//            'region_id',
            [
                'attribute'=>'region_id',
                'filter'=>\yii\helpers\ArrayHelper::map(\app\models\data\Regions::find()->all(),'id','name'),
                'value' => function ($model) {
                    $region_name = \app\models\data\Regions::findOne($model->region_id);
                    return $region_name->name; // region nomini chiqarish
                },
            ],
//            'branch_id',
            [
                'attribute'=>'branch_id',
                'filter'=>\yii\helpers\ArrayHelper::map(\app\models\data\Branches::find()->all(),'id','name'),
                'value' => function ($model) {
                    if (isset($model->branch_id)){
                        $branch_name = \app\models\data\Branches::findOne($model->branch_id);
                        $branch_name = $branch_name->name;
                    }
                    else $branch_name = "viloyat filiallari";
                    return $branch_name; // branch nomini chiqarish
                },
            ],

//            'user_id',
//            'file',
            [
                'attribute'=>'Fayl',
                'format' => 'raw',
//                'filter'=>\yii\helpers\ArrayHelper::map(\app\models\data\Regions::find()->all(),'id','name'),
                'value' => function ($model) {
                    $yuklash = $model->file;
                    return Html::a('Скачать', ['download', 'id' => $model->code], ['class' => 'btn btn-success']) ;
                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Orders $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'code' => $model->code]);
                 }
            ],
        ],
    ]); ?>


</div>
