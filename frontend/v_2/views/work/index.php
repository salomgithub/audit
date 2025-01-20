<?php

use app\models\data\Branches;
use app\models\data\Departaments;
use app\models\data\HeadMistakesGroup;
use app\models\data\Regions;
use app\models\Work;
use yii\bootstrap5\LinkPager;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\WorkSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Aniqlangan kamchiliklar jadvali';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
    function exportExcel() {
        var table = document.getElementById("source-table");
        var html = table.outerHTML;
        var url = 'data:application/vnd.ms-excel;charset=utf-8,' + encodeURIComponent(html);
        var link = document.createElement("a");
        link.href = url;
        link.download = "table.xls";
        link.click();
    }

</script>
<div class="work-index">



    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pager' => [
            'class' => \yii\widgets\LinkPager::class,
            'linkOptions' => ['class' => 'page-link'],
            'options' => ['class' => 'pagination justify-content-center'],
            'prevPageLabel' => '«',
            'nextPageLabel' => '»',
            'maxButtonCount' => 10,
            'prevPageCssClass' => 'page-item',
            'nextPageCssClass' => 'page-item',
            'activePageCssClass' => 'active',
            'disabledPageCssClass' => 'disabled',
        ],
        'tableOptions' => ['id' => 'source-table', 'class' => 'table table-striped table-bordered'],
        'filterSelector' => 'select[name="WorkSearch[perPage]"]',
        'options' => ['id' => 'table_id'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => '#',
                'format' => 'raw',
                'value' => function ($model) {
                    $work_id = $model->id;
                    $a = "<a href='view?id=$work_id'><i class='bi bi-folder' style='font-size: 30px;'></i></a>";
                    return $a;
                },
            ],
            'id',
            'farmoyish_id',
            [
                'attribute' => 'region_id',
                'filter' => ArrayHelper::map(Regions::find()->all(), 'id', 'name'),
                'value' => 'region.name'
            ],
            [
                'attribute' => 'branch_id',
                'filter' => ArrayHelper::map(Branches::find()->all(), 'id', 'name'),
                'value' => 'branch.name'
            ],
            'year',
//            'unical',
//            'client_name',
//            'head_mistakes_group_code',
            [
                'attribute' => 'head_mistakes_group_code',
                'filter' => ArrayHelper::map(HeadMistakesGroup::find()->all(), 'code', 'name'),
                'value' => 'headMistakesGroupCode.name'
            ],
            [
                'attribute' => 'mistake_code',
                'filter' => ArrayHelper::map(\app\models\data\Mistakes::find()->all(), 'code', 'name'),
                'value' => 'mistakeCode.name'
            ],
//            'mistake_code',
            'mistake_soni',
//            'mistake_sum',
            //'mistak_from_user',
//            'user_id',
            [
                'attribute' => 'mistake_sum',
//                'filter'=>ArrayHelper::map(\app\models\data\Mistakes::find()->all(),'code','name'),
                'value' => function ($model) {
                    $soni = $model->mistake_sum;
                    $soni = number_format($soni, 0, '', ' ');
                    return $soni;
                },
            ],
            'bartaraf_soni',
            'bartaraf_sum',

            [
                'attribute' => 'departament_id',
                'filter' => ArrayHelper::map(Departaments::find()->all(), 'id', 'name'),
                'value' => 'departament.name'
            ],
//            'work_status',
            [
                'attribute' => 'work_status',
                'format' => 'raw',
                'filter' => [
                    0 => 'Yangi',
                    1 => 'Jarayonda',
                    2 => 'Yopilgan',
                    3 => 'Tekshiruv vaqtida bartaraf',
                    4 => 'Rad',
                ],
                'value' => function ($model) {
                    $work_status = $model->work_status;
                    if ($work_status == 0)
                        return Html::a('Yangi', '#', ['class' => 'btn btn-info']);
                    if ($work_status == 1)
                        return Html::a('Jarayonda', ['worklistview', 'work_id' => $model->id], ['class' => 'btn btn-warning']);
                    if ($work_status == 2)
                        return Html::a('Yopilgan', '#', ['class' => 'btn btn-primary']);
                    if ($work_status == 3)
                        return Html::a('bartaraf', '#', ['class' => 'btn btn-info']);
                    if ($work_status == 4)
                        return Html::a('Rad', ['worklistview', 'work_id' => $model->id], ['class' => 'btn btn-danger']);

                },
            ],

            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, Work $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>


</div>
