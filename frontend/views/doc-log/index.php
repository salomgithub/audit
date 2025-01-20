<?php

use app\models\DocLog;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var frontend\models\DocLogSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Doc Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doc-log-index">

    <h1><?= Html::encode($this->title) ?></h1>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'work_id',
            'user_id',
            'action',
            'status_old',
            'status_new',
            'create_at',
            'ip',

        ],
    ]); ?>


</div>
