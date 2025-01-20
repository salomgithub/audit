<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\data\Orders $model */

$this->title = $model->code;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'code' => $model->code], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'code' => $model->code], [
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
            'code',
//            'name',
            'region_id',
            [
                'attribute' => 'Viloyat',
                // 'format' => 'raw',
                'value' => function(){

                    $a = \app\models\data\Orders::findOne($this->title);

                    $b = \app\models\data\Regions::findOne($a->region_id);

                    return $b->name;
                }
            ],
            'branch_id',
            [
                'attribute' => 'Filial',
                // 'format' => 'raw',
                'value' => function(){

                    $a = \app\models\data\Orders::findOne($this->title);
                    $branch_id = $a->branch_id;
                    if (isset($branch_id)) {
                        $b = \app\models\data\Branches::findOne($a->branch_id);
                        $b = $b->name;
                    }
                    else $b = "viloyat bo'yicha";

                    return $b;
                }
            ],
//            'user_id',
//            'file',
        ],
    ]) ?>

</div>
