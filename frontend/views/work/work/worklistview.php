<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Worklist $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Worklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="worklist-view">
    <p>
        <?= Html::a('Ordtga', ['/work/view', 'id' => $model->work_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Hujjatni  ochish', ['download', 'id' => $model->work_id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Qabul', ['work/qabul', 'work_id' => $model->work_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Bu kamchilik bartaraf qilindimi ?',
                'method' => 'post',
            ],
        ]) ?>


    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute'=>'Javobgar departament',
                'value' => function ($model) {
                    return \app\models\data\Departaments::findOne($model->dep_id)->name;
                },
            ],
            [
                'attribute'=>'Andiqlangan kamchilik',
//                'format' => 'raw',

                'value' => function ($model) {
                    $mistake_id = \app\models\Work::findOne($model->work_id)->mistake_code;
                    return \app\models\data\Mistakes::findOne($mistake_id)->name;
                },
            ],
            [
                'attribute'=>'Miqdor',
//                'format' => 'raw',

                'value' => function ($model) {
                    return \app\models\Work::findOne($model->work_id)->mistake_soni;
                },
            ],
            [
                'attribute'=>'Summa',
//                'format' => 'raw',

                'value' => function ($model) {
                    return \app\models\Work::findOne($model->work_id)->mistake_sum;
                },
            ],
//            'file',
            'commet',
            [
                'attribute'=>'status',
                'format' => 'raw',
                'filter' => [
                    0 => 'Jarayonda',
                    1 => 'Yopilgan',
                ],
                'value' => function ($model) {
                    $status = $model->status;
                    if ($status == 0)
                        return Html::a('Jarayonda','#', ['class' => 'btn btn-warning']) ;
                    if ($status == 1)
                        return Html::a('Rad qilingan','#', ['class' => 'btn btn-danger']) ;
                    if ($status == 2)
                        return Html::a('Yopilgan','#', ['class' => 'btn btn-primary']) ;
                    else return Html::a('Nomalum', '#',['class' => 'btn btn-primary']) ;
                },
            ],

        ],
    ]) ?>

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($xabar, 'xabar')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Rad qilish', ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
