<?php

use app\models\Balance;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

?>
<div class="employee-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'branch_id',
            'hisob_raqam',
            'hisob_raqam_nomi',
            'kirim_aktiv',
            'kirim_passiv',
            'debet',
            'kredit',
            'chiqim_aktiv',
            'chiqim_passiv',
            'from_data',
            'to_data',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Balance $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
