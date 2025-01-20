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
            'status',
        ],
    ]) ?>

</div>
