<?php

use app\models\data\Branches;
use app\models\data\Regions;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Work $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<?php
$this->registerCssFile("/main/vendor/bootstrap/css/bootstrap.min.css");
$this->registerCssFile("/main/vendor/bootstrap-icons/bootstrap-icons.css");
$this->registerCssFile("/main/vendor/boxicons/css/boxicons.min.css");
$this->registerCssFile("/main/vendor/quill/quill.snow.css");
$this->registerCssFile("/main/vendor/quill/quill.bubble.css");
$this->registerCssFile("/main/vendor/remixicon/remixicon.css");
$this->registerCssFile("/main/vendor/simple-datatables/style.css");
$this->registerCssFile("/main/css/style.css");
?>
<div class="card">
    <div class="card-body">
        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab"
                        data-bs-target="#home-justified" type="button" role="tab" aria-controls="home"
                        aria-selected="true">Батафсил
                </button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-justified"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">Тарих
                </button>
            </li>
            <?php if ($model->work_status === 0): ?>
                <li class="nav-item flex-fill " role="presentation">
                    <button class="nav-link w-100 <?= ($model->work_status != 0) ? ' disabled ' : '' ?>"
                            id="contact-tab"
                            data-bs-toggle="tab" data-bs-target="#contact-justified"
                            type="button" role="tab" aria-controls="contact" aria-selected="false">Жойида бартараф қилиш
                    </button>
                </li>
            <?php endif; ?>
        </ul>
        <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-body">

                                    <!-- Table with stripped rows -->
                                    <div class="work-view">

                                        <div class=" mt-3">
                                            <table class="table table-bordered">
                                                <tbody>
                                                <tr>
                                                    <td class="table-light">Status</td>
                                                    <td><?php
                                                        $work_status = $model->work_status;
                                                        if ($work_status == 0)
                                                            echo "<i class='btn btn-primary'>Янги</i>";
                                                        if ($work_status == 1)
                                                            echo Html::a('Жараёнда', ['worklistview', 'work_id' => $model->id], ['class' => 'btn btn-warning']);;
                                                        if ($work_status == 2)
                                                            echo Html::a('Ёпилган', ['worklistview', 'work_id' => $model->id], ['class' => 'btn btn-success']);;
                                                        if ($work_status == 3)
                                                            echo "<i class='btn btn-warning'>Текширув вақтида бартараф</i>";
                                                        if ($work_status == 4)
                                                            echo "<i class='btn btn-danger'>Рад қилинган</i>";
                                                        ?>
                                                    </td>
                                                    <td class="table-light">Текширилган йил</td>
                                                    <td><?= $model->year ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-light">Вилоят</td>
                                                    <td><?= Regions::findOne($model->region_id)->name ?></td>
                                                    <td class="table-light">Кредит ИД</td>
                                                    <td><?= $model->unical ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-light">Филиал</td>
                                                    <td><?= Branches::findOne($model->branch_id)->name ?></td>
                                                    <td class="table-light">Ҳисоб Рақам</td>
                                                    <td><?= $model->hisob_raqam ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-light">Департамент</td>
                                                    <td><?= \app\models\data\Departaments::findOne($model->departament_id)->name ?></td>
                                                    <td class="table-light">Бўлинма номи</td>
                                                    <td><?= \app\models\data\HeadMistakesGroup::findOne($model->head_mistakes_group_code)->name ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-light">Камчилик сабабчиси ФИО</td>
                                                    <td><?= $model->mistak_from_user ?></td>
                                                    <td class="table-light">Камчилик номи</td>
                                                    <td><?= \app\models\data\Mistakes::findOne($model->mistake_code)->name ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-light">Мижоз ФИО</td>
                                                    <td><?= $model->client_name ?></td>
                                                    <td class="table-light">Камчилик сони</td>
                                                    <td><?= $model->mistake_sum ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-light">Камчилик аниқлаган ҳодим</td>
                                                    <td><?= \common\models\User::findOne($model->user_id)->fio ?></td>
                                                    <td class="table-light">Камчилик суммаси</td>
                                                    <td><?= $model->mistake_soni ?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <hr>
                                        <div class="accordion-item">
                                            <table width="100%" class="table table-bordered">
                                                <tr>
                                                    <td>
                                                        <h2 class="accordion-header" id="flush-headingOne">
                                                            <button class="accordion-button collapsed" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#flush-collapseOne"
                                                                    aria-expanded="false"
                                                                    aria-controls="flush-collapseOne">
                                                                <?= \app\models\data\Mistakes::findOne($model->mistake_code)->name ?>
                                                            </button>
                                                        </h2>
                                                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                                                             aria-labelledby="flush-headingOne"
                                                             data-bs-parent="#accordionFlushExample">
                                                            <div class="accordion-body">
                                                                <?php $worklist = \frontend\models\Worklist::findOne(['work_id' => $model->id]);
                                                                $pdfPath1 = "/uploads/joyidabartaraf/{$model->id}.pdf";
                                                                $pdfPath2 = $worklist ? "/uploads/depbartaraf/{$worklist->work_id}.pdf" : '';
                                                                ?>
                                                                <?php if ((file_exists(Yii::getAlias('@webroot') . $pdfPath1)) || (file_exists(Yii::getAlias('@webroot') . $pdfPath2))) : ?>
                                                                    <?php if ($model->work_status === 3) : ?>
                                                                        <object data="/uploads/joyidabartaraf/<?= $model->id ?>.pdf"
                                                                                type="application/pdf" height="1000px"
                                                                                width="100%"></object>
                                                                    <?php elseif ($worklist !== null) : ?>
                                                                        <object data="/uploads/depbartaraf/<?= $worklist->work_id ?>.pdf"
                                                                                type="application/pdf" height="1000px"
                                                                                width="100%"></object>

                                                                    <?php endif; ?>
                                                                <?php else : ?>
                                                                    <br> <p>"Ҳужжат1 бириктирилмаган?????"</p>
                                                                <?php endif; ?>
                                                                <br>
                                                                <p>"Ҳужжат2 бириктирилмаган?????"</p>
                                                            </div>


                                                        </div>
                                                    </td>
                                                    <td>pdf</td>
                                                </tr>
                                            </table>

                                        </div>


                                    </div>
                                    <!-- End Table with stripped rows -->

                                </div>
                            </div>

                        </div>
                    </div>
                </section><!--Hammasi -->
            </div>
            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-body">

                                    <!-- Table with stripped rows -->
                                    <h2>Операциялар тарихи</h2>
                                    <table class="table" align="center">
                                        <tr>
                                            <td>ФИО</td>
                                            <td>Ҳаракат</td>
                                            <td>Вақт</td>
                                        </tr>
                                        <?php


                                        if ($log = \app\models\DocLog::find()->where(['work_id' => $model->id]) !== null) {
                                            $log = \app\models\DocLog::find()->where(['work_id' => $model->id])->all();
                                            foreach ($log as $item) {
                                                echo "<tr>";
                                                echo "<td>" . \mdm\admin\models\User::findOne($item->user_id)->fio . "</td>";
                                                echo "<td>" . $item->action . "</td>";
                                                echo "<td>" . $item->create_at . "</td>";
                                                echo "<tr>";
                                            }
                                        }

                                        ?>
                                    </table>
                                    <!-- End Table with stripped rows -->

                                </div>
                            </div>

                        </div>
                    </div>
                </section><!--Kech kelgan -->
            </div>
            <?php if ($model->work_status === 0): ?>
                <div class="tab-pane fade" id="contact-justified" role="tabpanel" aria-labelledby="contact-tab">
                    <section class="section">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="card">
                                    <div class="card-body">

                                        <!-- Table with stripped rows -->
                                        <div class="container mt-3">
                                            <?php
                                            $file = new \frontend\models\Worklist();

                                            ?>
                                            <?php $form = ActiveForm::begin(['action' => ['joyidabartaraf'],]);
                                            ?>

                                            <div class="row">
                                                <div class="col-md-7">
                                                    <?= $form->field($file, 'id')->textInput(['maxlength' => true, 'value' => $model->id, 'readonly' => true]) ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-7">
                                                </div>
                                                <div class="col-md-7">
                                                    <?= $form->field($file, 'file')->fileInput(['class' => 'btn btn-primary']) ?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <?= Html::submitButton('Yuborish', ['class' => 'btn btn-success']) ?>
                                            </div>

                                            <?php ActiveForm::end(); ?>


                                        </div>
                                        <!-- End Table with stripped rows -->

                                    </div>
                                </div>

                            </div>
                        </div>
                    </section><!-- Kelmagan -->
                </div>
            <?php endif; ?>
        </div><!-- End Default Tabs -->

    </div>
</div>


