<?php

use app\models\data\Mistakes;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\LinkPager;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\data\MistakesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Фойдаланувчилар рўйхати';
$this->params['breadcrumbs'][] = $this->title;
$i = 1;
?>
<div class="mistakes-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-striped table-bordered">
        <tr>
            <th>№</th>
            <th>Username</th>
            <th>FIO</th>
            <th>email</th>
            <th>status</th>
            <th>dep_id</th>
            <th>action</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= $user->username ?></td>
                <td><?= $user->fio ?></td>
                <td><?= $user->email ?></td>
                <td><?= $user->status ?></td>
                <td><?= \app\models\data\Departaments::findOne($user->dep_id)->name; ?></td>
                <td>
                    <?php $form = ActiveForm::begin([
                        'action' => ['reset_password'],
                        'method' => 'post',
                        ]); ?>
                    <?= $form->field($user, 'id')->hiddenInput(['value' => $user->id])->label(false) ?>

                    <?= $form->field($user, 'newPassword')->passwordInput()->label(false) ?>
                    <div class="form-group">
                        <?= Html::submitButton('Reset password', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </td>
            </tr>
            <?php $i++; ?>
        <?php endforeach; ?>

    </table>


</div>
