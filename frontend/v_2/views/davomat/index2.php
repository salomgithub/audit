<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


$form = ActiveForm::begin(); ?>
<div class="row ">
    <div class="col-md-2">
        <?= $form->field($model, 'data_start')->textInput(['type' => 'date', 'style' => 'width: 200px'])->label(false) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'data_end')->textInput(['type' => 'date', 'style' => 'width: 200px'])->label(false) ?>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <?= Html::submitButton('Hisobot olish', ['class' => 'btn btn-success', 'style' => 'width: 320px']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<table class="table-active">

</table>
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


<div class="pagetitle">
    <h1>Davomat kunma kun</h1>
    <nav>
        <ol class="breadcrumb">

        </ol>
    </nav>
</div><!-- End Page Title -->


<div class="card">
    <div class="card-body">
        <h5 class="card-title">Default Tabs Justified</h5>

        <!-- Default Tabs -->
        <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-justified" type="button" role="tab" aria-controls="home" aria-selected="true">Hammasi</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-justified" type="button" role="tab" aria-controls="profile" aria-selected="false">Kechikkanlar</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
                <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-justified" type="button" role="tab" aria-controls="contact" aria-selected="false">Kelmaganlar</button>
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
                                    <table class="table datatable">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">FIO</th>
                                            <th scope="col">IN</th>
                                            <th scope="col">OUT</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $startTime = strtotime('09:00:00');
                                        $endTime = strtotime('09:10:00');
                                        $finishTime = strtotime('18:00:00');
                                        foreach ($data as $items) {
                                            $targetTimeIn = strtotime(date("H:i:s", strtotime($items['in'])));
                                            $targetTimeOut = strtotime(date("H:i:s", strtotime($items['out'])));
                                            echo "<tr>";

                                            echo "<td><h6 style='color: red;'>".($items['data'] ?? '')."</h6></td>";
                                            echo "<td >$items[user_name]</td>";

                                            if ($targetTimeIn < $startTime) {
                                                $color = "black"; // qora
                                            } elseif ($targetTimeIn <= $endTime) {
                                                $color = "blue"; // sariq
                                            } else {
                                                $color = "red"; // qizil
                                            }

                                            $in = "<h6 style='color: $color;'>$items[in]</h6>";

                                            echo "<td >$in </td>";

                                            if ($targetTimeOut >= $finishTime) {
                                                $color = "black"; // qora
                                            } else {
                                                $color = "red"; // qizil
                                            }

                                            $out = "<h6 style='color: $color;'>$items[out]</h6>";
                                            echo "<td >$out</td>";

                                            echo "</tr>";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
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
                                    <table class="table datatable">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">FIO</th>
                                            <th scope="col">IN</th>
                                            <th scope="col">OUT</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $startTime = strtotime('09:00:00');
                                        $endTime = strtotime('09:10:00');
                                        $finishTime = strtotime('18:00:00');
                                        foreach ($data as $items) {
                                            if ($items['in'] == 0)
                                            $targetTimeIn = 0;
                                            else $targetTimeIn = strtotime(date("H:i:s", strtotime($items['in'])));
                                            $targetTimeOut = strtotime(date("H:i:s", strtotime($items['out'])));


                                            if ($targetTimeIn > $endTime || $targetTimeIn == '0') {
                                                $color = "red";
                                                echo "<tr>";

                                                echo "<td><h6 style='color: red;'>".($items['data'] ?? '')."</h6></td>";
                                                echo "<td >$items[user_name]</td>";
                                                $in = "<h6 style='color: $color;'>$items[in]</h6>";

                                                echo "<td >$in </td>";

                                                if ($targetTimeOut >= $finishTime) {
                                                    $color = "black"; // qora
                                                } else {
                                                    $color = "red"; // qizil
                                                }

                                                $out = "<h6 style='color: $color;'>$items[out]</h6>";
                                                echo "<td >$out</td>";

                                                echo "</tr>";
                                            }


                                        }
                                        ?>
                                        </tbody>
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
                                    <table class="table datatable">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">FIO</th>
                                            <th scope="col">IN</th>
                                            <th scope="col">OUT</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $startTime = strtotime('09:00:00');
                                        $endTime = strtotime('09:10:00');
                                        $finishTime = strtotime('18:00:00');
                                        foreach ($data as $items) {
                                            $targetTimeIn = strtotime(date("H:i:s", strtotime($items['in'])));
                                            $targetTimeOut = strtotime(date("H:i:s", strtotime($items['out'])));


                                            if ($items['in'] == '-') {
                                                $color = "red";
                                                echo "<tr>";

                                                echo "<td><h6 style='color: red;'>".($items['data'] ?? '')."</h6></td>";
                                                echo "<td >$items[user_name]</td>";
                                                $in = "<h6 style='color: $color;'>$items[in]</h6>";

                                                echo "<td >$in </td>";

                                                if ($targetTimeOut >= $finishTime) {
                                                    $color = "black"; // qora
                                                } else {
                                                    $color = "red"; // qizil
                                                }

                                                $out = "<h6 style='color: $color;'>$items[out]</h6>";
                                                echo "<td >$out</td>";

                                                echo "</tr>";
                                            }


                                        }
                                        ?>
                                        </tbody>
                                    </table>
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










<!-- Vendor JS Files -->
<?php

$this->registerJsFile("/main/vendor/apexcharts/apexcharts.min.js");
$this->registerJsFile("/main/vendor/bootstrap/js/bootstrap.bundle.min.js");
$this->registerJsFile("/main/vendor/chart.js/chart.umd.js");
$this->registerJsFile("/main/vendor/echarts/echarts.min.js");
$this->registerJsFile("/main/vendor/quill/quill.min.js");
$this->registerJsFile("/main/vendor/simple-datatables/simple-datatables.js");
$this->registerJsFile("/main/vendor/tinymce/tinymce.min.js");
$this->registerJsFile("/main/vendor/php-email-form/validate.js");
$this->registerJsFile("/main/js/main.js");
?>

<!-- Template Main JS File -->



