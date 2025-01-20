<?php

/** @var yii\web\View $this */

use app\models\data\HeadMistakesGroup;
use app\models\Work;

$this->title = 'Hisobot';
$umumiy = Work::find()->count();
$departaments = \app\models\data\Departaments::find()->all();

?>
<div class="site-index">
    <div class="  bg-transparent rounded-3">
        <div class="  text-center">
            <h1 class="display-4">Hisobot</h1>
            <table class="table table-striped table-bordered">
                <tr>
                    <th rowspan="3">Таркибий бўлинмалар номи</th>
                    <th colspan="4">Кредит амалиётлари бўйича камчиликлар</th>
                    <th colspan="4">Бухгалтерия амалиёти бўйича</th>
                    <th colspan="4">Чакана амалиётлар</th>
                    <th colspan="4">Банк карталари сектори</th>
                    <th colspan="4">Касса амалиётлари бўйича</th>
                    <th colspan="4">Узлаштириш</th>

                </tr>
                <tr>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>
                    <th rowspan="2">Сони</th>
                    <th rowspan="2">Суммаси</th>
                    <th colspan="2">Шундан бартараф қилинди</th>

                </tr>
                <tr>
                    <th>Сони</th>
                    <th>Суммаси</th>
                    <th>Сони</th>
                    <th>Суммаси</th>
                    <th>Сони</th>
                    <th>Суммаси</th>
                    <th>Сони</th>
                    <th>Суммаси</th>
                    <th>Сони</th>
                    <th>Суммаси</th>
                    <th>Сони</th>
                    <th>Суммаси</th>
                </tr>

                <?php
                $head_mistakes = HeadMistakesGroup::find()->all();
                echo "<tr>";
                echo "<td></td>";
                foreach ($head_mistakes as $head_mistake) {
                    $son = Work::find()->where(['work_status' => 0, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])->count();

                    if ($son > 0) {
                        $son = number_format($son, 0, '', ' ');
                        $sum = Work::find()->where(['work_status' => 0, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_sum');
                        $sum = is_numeric($sum) ? number_format($sum, 0, '', ' ') : '';
                        $bartaraf_son = Work::find()->where(['work_status' => 2, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])->count();
                        $bartaraf_son = number_format($bartaraf_son, 0, '', ' ');
                        $bartaraf_sum = Work::find()->where(['work_status' => 2, 'departament_id' => $departament->id, 'head_mistakes_group_code' => $head_mistake->code])->sum('mistake_sum');
                        $bartaraf_sum = is_numeric($bartaraf_sum) ? number_format($bartaraf_sum, 0, '', ' ') : '';
                    } else {
                        $son = '-';
                        $sum = '-';
                        $bartaraf_son = '-';
                        $bartaraf_sum = '-';

                    }

                    echo "<td>" . $son . "</td>";
                    echo "<td>" . $sum . "</td>";
                    echo "<td>" . $bartaraf_son . "</td>";
                    echo "<td>" . $bartaraf_sum . "</td>";
                }


                echo "</tr>";


                ?>

            </table>


        </div>
    </div>

    <div class="body-content">

    </div>
</div>
