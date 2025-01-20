<?php

use app\models\data\Branches;
use app\models\data\Regions;
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
                        aria-selected="true">Batafsil
                </button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-justified"
                        type="button" role="tab" aria-controls="profile" aria-selected="false">Tarix
                </button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-justified"
                        type="button" role="tab" aria-controls="contact" aria-selected="false">Yuklangan hujjat
                </button>
            </li>
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
                                                            echo "<i class='btn btn-primary'>Yangi</i>";
                                                        if ($work_status == 1)
                                                            echo Html::a('Jarayonda', ['worklistview', 'work_id' => $model->id], ['class' => 'btn btn-warning']);;
                                                        if ($work_status == 3)
                                                            echo "<i class='btn btn-warning'>Tekshiruv vaqtida bartaraf</i>";
                                                        if ($work_status == 4)
                                                            echo "<i class='btn btn-success'>Yopilgan</i>";
                                                        ?>
                                                    </td>
                                                    <td class="table-light">Tekshirilgan yil</td>
                                                    <td><?= $model->year ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-light">Viloyat</td>
                                                    <td><?= Regions::findOne($model->region_id)->name ?></td>
                                                    <td class="table-light">Kredit ID</td>
                                                    <td><?= $model->unical ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-light">Filial</td>
                                                    <td><?= Branches::findOne($model->branch_id)->name ?></td>
                                                    <td class="table-light">Hisob Raqam</td>
                                                    <td><?= $model->hisob_raqam ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-light">Departament</td>
                                                    <td><?= \app\models\data\Departaments::findOne($model->departament_id)->name ?></td>
                                                    <td class="table-light">Bo`linma nomi</td>
                                                    <td><?= \app\models\data\HeadMistakesGroup::findOne($model->head_mistakes_group_code)->name ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-light">Kamchilik sababchisi FIO</td>
                                                    <td><?= $model->mistak_from_user ?></td>
                                                    <td class="table-light">Kamchilik nomi</td>
                                                    <td><?= \app\models\data\Mistakes::findOne($model->mistake_code)->name ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-light">Mijoz FIO</td>
                                                    <td><?= $model->client_name ?></td>
                                                    <td class="table-light">Kamchilik soni</td>
                                                    <td><?= $model->mistake_sum ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="table-light">Kamchilik aniqlagan hodim</td>
                                                    <td><?= \common\models\User::findOne($model->user_id)->fio ?></td>
                                                    <td class="table-light">Kamchilik summasi</td>
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
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                                <?= \app\models\data\Mistakes::findOne($model->mistake_code)->name ?>
                                                            </button>
                                                        </h2>
                                                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                            <div class="accordion-body">
                                                                <?php
                                                                $worklist = \frontend\models\Worklist::findOne(['work_id' => $model->id]);

                                                                if ($worklist !== null) {
                                                                    ?>
                                                                    <object data="/uploads/depbartaraf/<?= $worklist->work_id ?>.pdf" type="application/pdf" height="1000px" width="100%"></object>
                                                                    <?php
                                                                } else {
                                                                    // Handle the case when no Worklist object is found
                                                                    // For example: echo an error message or provide a default PDF
                                                                    echo "Hujjat biriktirilmagan";
                                                                }
                                                                ?>
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
                                    <h2>Operatsiyalar tarixi</h2>
                                    <table class="table" align="center">
                                        <tr>
                                            <td>FIO</td>
                                            <td>Harakat</td>
                                            <td>Vaqt</td>
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
            <div class="tab-pane fade" id="contact-justified" role="tabpanel" aria-labelledby="contact-tab">
                <section class="section">
                    <div class="row">
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-body">

                                    <!-- Table with stripped rows -->
                                    <div class="container mt-3">

                                                    <?php
                                                    $worklist = \frontend\models\Worklist::findOne(['work_id' => $model->id]);

                                                    if ($worklist !== null) {
                                                        ?>
                                                        <object data="/uploads/depbartaraf/<?= $worklist->work_id ?>.pdf" type="application/pdf" height="1000px" width="100%"></object>
                                                        <?php
                                                    } else {
                                                        // Handle the case when no Worklist object is found
                                                        // For example: echo an error message or provide a default PDF
                                                        echo "Hujjat biriktirilmagan";
                                                    }
                                                    ?>

                                    </div>
                                    <!-- End Table with stripped rows -->

                                </div>
                            </div>

                        </div>
                    </div>
                </section><!-- Kelmagan -->
            </div>
        </div><!-- End Default Tabs -->

    </div>
</div>


