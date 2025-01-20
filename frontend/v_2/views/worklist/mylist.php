<?php


use frontend\models\Worklist;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\WorklistSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = $dep_name;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="worklist-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-striped table-bordered">
        <tr>
            <td>id</td>
            <td>Comment</td>
            <td>...</td>
        </tr>
        <?php

        foreach ($list as $item) {
            echo "<tr>";
            echo "<td>" . $item->work_id . "</td>";
            echo "<td>" . $item->coment . "</td>";
//            echo "<td>" . $item->mistake_sum . "</td>";
            echo "<td>" . Html::a('ochish', ['edit', 'id' => $item->id], ['class' => 'btn btn-primary']) . "<tr>";

        }
        ?>

    </table>


</div>
