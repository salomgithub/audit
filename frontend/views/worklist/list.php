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

    <?php  echo $this->render('_search_bartaraf', ['model' => $searchModel]); ?>
    <hr>
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
//            'farmoyish_id',
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
            'client_name',
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
            [
                'attribute' => 'work_status',
                'format' => 'raw',
                'filter' => [
                    0 => 'Янги',
                    1 => 'Жараёнда',
                    4 => 'Рад қилинган',
                ],
                'value' => function ($model) {
                    $work_status = $model->work_status;
                    if ($work_status === 0)
                        return Html::a('Янги', '#', ['class' => 'btn btn-info']);
                    if ($work_status === 1)
                        return Html::a('Жараёнда', '#', ['class' => 'btn btn-warning']);
                    if ($work_status === 2)
                        return Html::a('Ёпилган', '#', ['class' => 'btn btn-success']);
                    if ($work_status === 3)
                        return '<p>Текширув вақтида бартараф';
                    if ($work_status === 4)
                        return Html::a('Рад қилинган', '#', ['class' => 'btn btn-danger']);

                },
            ],
        ],
    ]); ?>


</div>
