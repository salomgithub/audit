<?php

namespace frontend\controllers;

use app\models\AuthAssignment;
use app\models\Balance;
use app\models\BalanceData;
use app\models\BalanceSearch;
use app\models\data\Branches;
use app\models\data\Departaments;
use app\models\data\Mistakes;
use app\models\data\Regions;
use app\models\data\Status;
use app\models\DocLog;
use app\models\CodeForm;
use app\models\Work;
use app\models\search\WorkSearch;
use app\models\Xabar;
use DateTime;
use DivisionByZeroError;
use frontend\models\Worklist;
use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

;


class FinanceController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionImport()
    {
        $model = new CodeForm();
        $regions = Regions::find()->all();

        if (Yii::$app->request->isPost && $model->load($this->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $user_id = Yii::$app->user->id ?? 1;
            if ($model->upload()) {
                $excelData = $model->getArrayDataFromExcel();
                // Fayldagi ma'lumotlarni ekranga chiqarish
                echo "<pre>";
                $a = $excelData[8]["C"];
                $b = $excelData[8]["G"];
                // Sanani ajratib olish uchun regex
                preg_match('/\d{2}\.\d{2}\.\d{4}/', $a, $from);
                preg_match('/\d{2}\.\d{2}\.\d{4}/', $b, $to);

                $from = isset($from[0]) ? $from[0] : 'Sanani topilmadi';
                $to = isset($to[0]) ? $to[0] : 'Sanani topilmadi';

                $date_from = DateTime::createFromFormat('d.m.Y', $from);
                $date_to = DateTime::createFromFormat('d.m.Y', $to);

                $from = date('Y-m-d', $date_from->getTimestamp());
                $to = date('Y-m-d', $date_to->getTimestamp());

                unset($excelData[1]);
                unset($excelData[2]);
                unset($excelData[3]);
                unset($excelData[4]);
                unset($excelData[5]);
                unset($excelData[6]);
                unset($excelData[7]);
                unset($excelData[8]);
                unset($excelData[9]);
                unset($excelData[10]);

                $c[8] = 0;
                $i = 0;

                foreach ($excelData as $excelDatum) {

                    $balance = new Balance();
                    $balance->branch_id = $model->branch_id;
                    $balance->from_data = $from;
                    $balance->to_data = $to;
                    $balance->hisob_raqam = $excelDatum["A"] ?? "0";
                    $balance->hisob_raqam_nomi = $excelDatum["B"] ?? '-';
                    $balance->kirim_aktiv = round(
                        floatval(str_replace(
                            ',', '', $excelDatum["C"] ?? 0)), 1);

                    $balance->kirim_passiv = round(
                        floatval(str_replace(
                            ',', '', $excelDatum["D"] ?? 0)), 1);

                    $balance->debet = round(
                        floatval(str_replace(
                            ',', '', $excelDatum["E"] ?? 0)), 1);

                    $balance->kredit = round(
                        floatval(str_replace(
                            ',', '', $excelDatum["F"] ?? 0)), 1);

                    $balance->chiqim_aktiv = round(
                        floatval(str_replace(
                            ',', '', $excelDatum["G"] ?? 0)), 1);

                    $balance->chiqim_passiv = round(
                        floatval(str_replace(
                            ',', '', $excelDatum["H"] ?? 0)), 1);

                    if ($balance->hisob_raqam != 0) $balance->save();

                    echo "<h1>" . $i++ . "\n" . $excelDatum["A"] . "</h1>";
                    var_dump($balance->errors);

                }
                die("STOP");

                if (12100 === ((int)$excelDatum["B"] ?? 0)) {
                    $c[8] += str_replace(',', '', $excelDatum["C"]);
                }

                if (12600 === ((int)$excelDatum["B"] ?? 0)) {
                    $c[8] += str_replace(',', '', $excelDatum["C"]);
                }
                if (12100 === ((int)$excelDatum["B"] ?? 0)) {
                    $c[8] += str_replace(',', '', $excelDatum["C"]);
                }
                if (12300 === ((int)$excelDatum["B"] ?? 0)) {
                    $c[8] += str_replace(',', '', $excelDatum["C"]);
                }
                if (12400 === ((int)$excelDatum["B"] ?? 0)) {
                    $c[8] += str_replace(',', '', $excelDatum["C"]);
                }
                if (12500 === ((int)$excelDatum["B"] ?? 0)) {
                    $c[8] += str_replace(',', '', $excelDatum["C"]);
                }
                if (12700 === ((int)$excelDatum["B"] ?? 0)) {
                    $c[8] += str_replace(',', '', $excelDatum["C"]);
                }
                if (12900 === ((int)$excelDatum["B"] ?? 0)) {
                    $c[8] += str_replace(',', '', $excelDatum["C"]);
                }
                if (13000 === ((int)$excelDatum["B"] ?? 0)) {
                    $c[8] += str_replace(',', '', $excelDatum["C"]);
                }
                if (13100 === ((int)$excelDatum["B"] ?? 0)) {
                    $c[8] += str_replace(',', '', $excelDatum["C"]);
                }
                if (13200 === ((int)$excelDatum["B"] ?? 0)) {
                    $c[8] += str_replace(',', '', $excelDatum["C"]);
                }
                if (13300 === ((int)$excelDatum["B"] ?? 0)) {
                    $c[8] += str_replace(',', '', $excelDatum["C"]);
                }


//                    $finance['mistakes'][] = [
//                        'son' => $son,
//                        'sum' => $sum,
//                        'bartaraf_son' => $bartaraf_son,
//                        'bartaraf_sum' => $bartaraf_sum,
//                    ];

//                $c[8] = round($c[8] / 1000, 1);
//                echo "<h1>$c[8]</h1>";
//                echo "<h1>$from</h1>";
//                echo "<h1>$to</h1>";
//                die();
                echo "</table>";
//                var_dump($excelData);

                die();
                foreach ($excelData as $excelDatum) {
                    $work = new Work();
                    $msitake_son = (int)$excelDatum["L"] ?? 0;
                    $msitake_sum = (int)(($excelDatum["M"] ?? 0) * 1000);
                    $bartaraf_son = (int)$excelDatum["N"] ?? 0;
                    $bartaraf_sum = (int)(($excelDatum["O"] ?? 0) * 1000);

                    $branch = Branches::findOne(['id' => ($excelDatum["E"] ?? 0)]);
                    if ($branch !== null) {
                        $branch_id = $branch->id;
                    } else {
                        $branch_name = Branches::findOne(['name' => ($excelDatum["F"] ?? 0)]);
                        if ($branch_name !== null) {
                            $branch_id = $branch_name->id;
                        } else {
                            die($excelDatum["A"] . " - qatordagi " . $excelDatum["F"] . " ni tekshiring :::1");
                        }
                    }
                    $work->branch_id = $branch_id;
                    $work->region_id = ((int)$excelDatum["B"]) ?? 0;
                    $work->farmoyish_id = $excelDatum["AK"] ?? 0;
                    $work->year = $excelDatum["D"] ?? 0;
                    $unical = strlen(($excelDatum["G"] ?? "00"));
                    if ($unical == 20) {
                        $work->unical = 0;
                        $work->hisob_raqam = $excelDatum["G"];
                    } else {
                        $work->unical = $excelDatum["G"] ?? 0;
                        $work->hisob_raqam = "0";
                    }
                    $work->client_name = $excelDatum["H"] ?? 0;
                    $work->head_mistakes_group_code = substr($excelDatum["I"], 0, 4) ?? 0;
                    $work->mistake_code = $excelDatum["I"] ?? 0;
                    $work->status = Status::findOne(['name' => $excelDatum["K"]])->id ?? 0;
                    if ($excelDatum["AF"] == '' || $excelDatum["AF"] == null) {
                        $a = 'no';
                    } else $a = $excelDatum["AF"];
                    $work->mistak_from_user = $a;
                    $work->user_id = $user_id;
                    $dep = Departaments::findOne(['name' => $excelDatum["AI"]]);
                    if ($dep === null) {
                        echo "<script>alert('" . $excelDatum["A"] . " qatorda " . $excelDatum["AI"] . " ma\'lumot bazadan  topilmadi. Xatolik!');</script>";
                        die();
                    } else $work->departament_id = $dep->id;
                    $work->comment = $excelDatum["AJ"] ?? '-';
                    $work->uzlashtirish = Mistakes::findOne($excelDatum["I"])->uzlashtirish ?? 0;

                    if ($msitake_sum == $bartaraf_sum && $msitake_sum != 0) {
                        $work->mistake_soni = $msitake_son;
                        $work->mistake_sum = $msitake_sum;
                        $work->bartaraf_soni = $bartaraf_son;
                        $work->bartaraf_sum = $bartaraf_sum;
                        $work->work_status = 3;
                        if ($work->save()) {
                            continue;
                        } else {
                            echo '<script>alert("№ ' . $excelDatum["A"] . ' qatorda  Xatolik 001  - ");</script>';
                            print_r($excelDatum["A"]);
                            var_dump($work->errors);
                            die();
                        }
                    } elseif (($msitake_sum > 0) && ($bartaraf_sum > 0) && ($msitake_sum > $bartaraf_sum)) {
                        $work->mistake_soni = $msitake_son;
                        $work->mistake_sum = $bartaraf_sum;
                        $work->bartaraf_soni = $bartaraf_son;
                        $work->bartaraf_sum = $bartaraf_sum;
                        $work->work_status = 3;

                        $new_work = new Work();
                        $new_work->mistake_soni = $msitake_son;
                        $new_work->mistake_sum = ($msitake_sum - $bartaraf_sum);
                        $new_work->bartaraf_soni = 0;
                        $new_work->bartaraf_sum = 0;
                        $new_work->work_status = 0;
                        $new_work->branch_id = $work->branch_id;
                        $new_work->region_id = $work->region_id;
                        $new_work->farmoyish_id = $work->farmoyish_id;
                        $new_work->year = $work->year;
                        $new_work->unical = $work->unical;
                        $new_work->hisob_raqam = $work->hisob_raqam;
                        $new_work->client_name = $work->client_name;
                        $new_work->head_mistakes_group_code = $work->head_mistakes_group_code;
                        $new_work->mistake_code = $work->mistake_code;
                        $new_work->status = $work->status;
                        $new_work->mistak_from_user = $work->mistak_from_user;
                        $new_work->user_id = $work->user_id;
                        $new_work->departament_id = $work->departament_id;
                        $new_work->comment = $work->comment;
                        $new_work->uzlashtirish = $work->uzlashtirish;
                        if ($work->save() && $new_work->save()) {
                            continue;
                        } else {
                            echo '<script>alert("№ ' . $excelDatum["A"] . ' qatorda  Xatolik 002  - ");</script>';
                            print_r($excelDatum["A"]);
                            var_dump($work->errors);
                            var_dump($new_work->errors);
                            die();
                        }
                    } elseif (($msitake_sum > 0) && ($bartaraf_sum == 0)) {
                        $work->mistake_soni = $msitake_son;
                        $work->mistake_sum = $msitake_sum;
                        $work->bartaraf_soni = 0;
                        $work->bartaraf_sum = 0;
                        $work->work_status = 0;
                        if ($work->save()) {
                            continue;
                        } else {
                            echo '<script>alert("№ ' . $excelDatum["A"] . ' qatorda  Xatolik 003  - ");</script>';
                            print_r($excelDatum["A"]);
                            var_dump($work->errors);
                            die();
                        }
                    } elseif (($msitake_son > 0) && ($bartaraf_son == 0)) {
                        $work->mistake_soni = $msitake_son;
                        $work->mistake_sum = $msitake_sum;
                        $work->bartaraf_soni = $bartaraf_son;
                        $work->bartaraf_sum = $bartaraf_sum;
                        $work->work_status = 0;
                        if ($work->save()) {
                            continue;
                        } else {
                            echo '<script>alert("№ ' . $excelDatum["A"] . ' qatorda  Xatolik 004  - ");</script>';
                            print_r($excelDatum["A"]);
                            var_dump($work->errors);
                            die();
                        }
                    } elseif (($msitake_sum == 0) && ($bartaraf_sum == 0) && ($msitake_son > 0) && ($msitake_son == $bartaraf_son)) {
                        $work->mistake_soni = $msitake_son;
                        $work->mistake_sum = 0;
                        $work->bartaraf_soni = $bartaraf_son;
                        $work->bartaraf_sum = 0;
                        $work->work_status = 3;
                        if ($work->save()) {
                            continue;
                        } else {
                            echo '<script>alert("№ ' . $excelDatum["A"] . ' qatorda  Xatolik 005  - ");</script>';
                            print_r($excelDatum["A"]);
                            var_dump($work->errors);
                            die();
                        }
                    } elseif (($msitake_sum == 0) && ($bartaraf_sum == 0) && ($msitake_son > 0) && ($msitake_son > $bartaraf_son)) {
                        $work->mistake_soni = $bartaraf_son;
                        $work->mistake_sum = 0;
                        $work->bartaraf_soni = $bartaraf_son;
                        $work->bartaraf_sum = 0;
                        $work->work_status = 3;

                        $new_work = new Work();
                        $new_work->mistake_soni = ($msitake_son - $bartaraf_son);
                        $new_work->mistake_sum = 0;
                        $new_work->bartaraf_soni = 0;
                        $new_work->bartaraf_sum = 0;
                        $new_work->work_status = 0;
                        $new_work->branch_id = $work->branch_id;
                        $new_work->region_id = $work->region_id;
                        $new_work->farmoyish_id = $work->farmoyish_id;
                        $new_work->year = $work->year;
                        $new_work->unical = $work->unical;
                        $new_work->hisob_raqam = $work->hisob_raqam;
                        $new_work->client_name = $work->client_name;
                        $new_work->head_mistakes_group_code = $work->head_mistakes_group_code;
                        $new_work->mistake_code = $work->mistake_code;
                        $new_work->status = $work->status;
                        $new_work->mistak_from_user = $work->mistak_from_user;
                        $new_work->user_id = $work->user_id;
                        $new_work->departament_id = $work->departament_id;
                        $new_work->comment = $work->comment;
                        $new_work->uzlashtirish = $work->uzlashtirish;

                        if ($work->save() && $new_work->save()) {
                            continue;
                        } else {
                            echo '<script>alert("№ ' . $excelDatum["A"] . ' qatorda  Xatolik 006  - ");</script>';
                            print_r($excelDatum["A"]);
                            var_dump($work->errors);
                            die();
                        }
                    } else {
                        die($excelDatum["A"] . " - qatorni  tekshiring :::0000007");

                    }
                }


            }
            $uploadsDirectory = 'uploads/';

            $files = glob($uploadsDirectory . '*');
            foreach ($files as $file) {
                if (is_file($file))
                    unlink($file);
            }
            $this->redirect('/work/index');
        }

        return $this->render('import', [
            'model' => $model,
            'regions' => $regions,
            ]);
    }

    public function actionImporttest()
    {
        $model = new CodeForm();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $user_id = Yii::$app->user->id ?? 1;
            if ($model->upload()) {
                $excelData = $model->getArrayDataFromExcel();
                // Fayldagi ma'lumotlarni ekranga chiqarish
                echo "<pre>";
                unset($excelData[1]);
                foreach ($excelData as $excelDatum) {
                    $work = new Work();
                    $msitake_son = (int)$excelDatum["L"] ?? 0;
                    $msitake_sum = (int)(($excelDatum["M"] ?? 0) * 1000);
                    $bartaraf_son = (int)$excelDatum["N"] ?? 0;
                    $bartaraf_sum = (int)(($excelDatum["O"] ?? 0) * 1000);

                    $branch = Branches::findOne(['id' => ($excelDatum["E"] ?? 0)]);
                    if ($branch !== null) {
                        $work->branch_id = $branch->id;
                    } else {
                        $branch_name = Branches::findOne(['name' => ($excelDatum["F"] ?? 0)]);
                        if ($branch_name !== null) {
                            $work->branch_id = $branch_name->id;
                        } else {
                            die($excelDatum["A"] . " - qatordagi " . $excelDatum["F"] . " ni tekshiring :::1");
                        }
                    }
                    // $work->branch_id = $branch->id;
                    $work->region_id = ((int)$excelDatum["B"]) ?? 0;
                    $work->farmoyish_id = $excelDatum["AK"] ?? 0;
                    $work->year = $excelDatum["D"] ?? 0;
                    $unical = strlen(($excelDatum["G"] ?? "00"));
                    if ($unical == 20) {
                        $work->unical = 0;
                        $work->hisob_raqam = $excelDatum["G"];
                    } else {
                        $work->unical = $excelDatum["G"] ?? 0;
                        $work->hisob_raqam = "0";
                    }
                    $work->client_name = $excelDatum["H"] ?? 0;
                    $work->head_mistakes_group_code = substr($excelDatum["I"], 0, 4) ?? 0;
                    $work->mistake_code = $excelDatum["I"] ?? 0;
                    $work->status = Status::findOne(['name' => $excelDatum["K"]])->id ?? 0;
                    if ($excelDatum["AF"] == '' || $excelDatum["AF"] == null) {
                        $a = 'no';
                    } else $a = $excelDatum["AF"];
                    $work->mistak_from_user = $a;
                    $work->user_id = $user_id;
                    $dep = Departaments::findOne(['name' => $excelDatum["AI"]]);
                    if ($dep === null) {
                        echo "<script>alert('" . $excelDatum["A"] . " qatorda " . $excelDatum["AI"] . " ma\'lumot bazadan  topilmadi. Xatolik!');</script>";
                        die();
                    } else $work->departament_id = $dep->id;
                    $work->comment = $excelDatum["AJ"] ?? '-';
                    $work->uzlashtirish = Mistakes::findOne($excelDatum["I"])->uzlashtirish ?? 0;

                    if ($msitake_sum == $bartaraf_sum && $msitake_sum != 0) {
                        $work->mistake_soni = $msitake_son;
                        $work->mistake_sum = $msitake_sum;
                        $work->bartaraf_soni = $bartaraf_son;
                        $work->bartaraf_sum = $bartaraf_sum;
                        $work->work_status = 3;
                        if ($work->validate()) {
                            continue;
                        } else {
                            echo '<script>alert("№ ' . $excelDatum["A"] . ' qatorda  Xatolik 001  - ");</script>';
                            print_r($excelDatum["A"]);
                            var_dump($work->errors);
                            die();
                        }
                    } elseif (($msitake_sum > 0) && ($bartaraf_sum > 0) && ($msitake_sum > $bartaraf_sum)) {
                        $work->mistake_soni = $msitake_son;
                        $work->mistake_sum = $bartaraf_sum;
                        $work->bartaraf_soni = $bartaraf_son;
                        $work->bartaraf_sum = $bartaraf_sum;
                        $work->work_status = 3;

                        $new_work = new Work();
                        $new_work->mistake_soni = $msitake_son;
                        $new_work->mistake_sum = ($msitake_sum - $bartaraf_sum);
                        $new_work->bartaraf_soni = 0;
                        $new_work->bartaraf_sum = 0;
                        $new_work->work_status = 0;
                        $new_work->branch_id = $work->branch_id;
                        $new_work->region_id = $work->region_id;
                        $new_work->farmoyish_id = $work->farmoyish_id;
                        $new_work->year = $work->year;
                        $new_work->unical = $work->unical;
                        $new_work->hisob_raqam = $work->hisob_raqam;
                        $new_work->client_name = $work->client_name;
                        $new_work->head_mistakes_group_code = $work->head_mistakes_group_code;
                        $new_work->mistake_code = $work->mistake_code;
                        $new_work->status = $work->status;
                        $new_work->mistak_from_user = $work->mistak_from_user;
                        $new_work->user_id = $work->user_id;
                        $new_work->departament_id = $work->departament_id;
                        $new_work->comment = $work->comment;
                        $new_work->uzlashtirish = $work->uzlashtirish;
                        if ($work->validate() && $new_work->validate()) {
                            continue;
                        } else {
                            echo '<script>alert("№ ' . $excelDatum["A"] . ' qatorda  Xatolik 002  - ");</script>';
                            print_r($excelDatum["A"]);
                            var_dump($work->errors);
                            var_dump($new_work->errors);
                            die();
                        }
                    } elseif (($msitake_sum > 0) && ($bartaraf_sum == 0)) {
                        $work->mistake_soni = $msitake_son;
                        $work->mistake_sum = $msitake_sum;
                        $work->bartaraf_soni = 0;
                        $work->bartaraf_sum = 0;
                        $work->work_status = 0;
                        if ($work->validate()) {
                            continue;
                        } else {
                            echo '<script>alert("№ ' . $excelDatum["A"] . ' qatorda  Xatolik 003  - ");</script>';
                            print_r($excelDatum["A"]);
                            var_dump($work->errors);
                            die();
                        }
                    } elseif (($msitake_son > 0) && ($bartaraf_son == 0)) {
                        $work->mistake_soni = $msitake_son;
                        $work->mistake_sum = $msitake_sum;
                        $work->bartaraf_soni = $bartaraf_son;
                        $work->bartaraf_sum = $bartaraf_sum;
                        $work->work_status = 0;
                        if ($work->validate()) {
                            continue;
                        } else {
                            echo '<script>alert("№ ' . $excelDatum["A"] . ' qatorda  Xatolik 004  - ");</script>';
                            print_r($excelDatum["A"]);
                            var_dump($work->errors);
                            die();
                        }
                    } elseif (($msitake_sum == 0) && ($bartaraf_sum == 0) && ($msitake_son > 0) && ($msitake_son == $bartaraf_son)) {
                        $work->mistake_soni = $msitake_son;
                        $work->mistake_sum = 0;
                        $work->bartaraf_soni = $bartaraf_son;
                        $work->bartaraf_sum = 0;
                        $work->work_status = 3;
                        if ($work->validate()) {
                            continue;
                        } else {
                            echo '<script>alert("№ ' . $excelDatum["A"] . ' qatorda  Xatolik 005  - ");</script>';
                            print_r($excelDatum["A"]);
                            var_dump($work->errors);
                            die();
                        }
                    } elseif (($msitake_sum == 0) && ($bartaraf_sum == 0) && ($msitake_son > 0) && ($msitake_son > $bartaraf_son)) {
                        $work->mistake_soni = $bartaraf_son;
                        $work->mistake_sum = 0;
                        $work->bartaraf_soni = $bartaraf_son;
                        $work->bartaraf_sum = 0;
                        $work->work_status = 3;

                        $new_work = new Work();
                        $new_work->mistake_soni = ($msitake_son - $bartaraf_son);
                        $new_work->mistake_sum = 0;
                        $new_work->bartaraf_soni = 0;
                        $new_work->bartaraf_sum = 0;
                        $new_work->work_status = 0;
                        $new_work->branch_id = $work->branch_id;
                        $new_work->region_id = $work->region_id;
                        $new_work->farmoyish_id = $work->farmoyish_id;
                        $new_work->year = $work->year;
                        $new_work->unical = $work->unical;
                        $new_work->hisob_raqam = $work->hisob_raqam;
                        $new_work->client_name = $work->client_name;
                        $new_work->head_mistakes_group_code = $work->head_mistakes_group_code;
                        $new_work->mistake_code = $work->mistake_code;
                        $new_work->status = $work->status;
                        $new_work->mistak_from_user = $work->mistak_from_user;
                        $new_work->user_id = $work->user_id;
                        $new_work->departament_id = $work->departament_id;
                        $new_work->comment = $work->comment;
                        $new_work->uzlashtirish = $work->uzlashtirish;

                        if ($work->validate() && $new_work->validate()) {
                            continue;
                        } else {
                            echo '<script>alert("№ ' . $excelDatum["A"] . ' qatorda  Xatolik 006  - ");</script>';
                            print_r($excelDatum["A"]);
                            var_dump($work->errors);
                            die();
                        }
                    } else {
                        die($excelDatum["A"] . " - qatorni  tekshiring :::0000007");

                    }
                }
            }
            $uploadsDirectory = 'uploads/';

            $files = glob($uploadsDirectory . '*');
            foreach ($files as $file) {
                if (is_file($file))
                    unlink($file);
            }
            $this->redirect('/work/index');
        }

        return $this->render('import', ['model' => $model]);
    }

    public function actionAktivlar()
    {
        $searchModel = new BalanceSearch();

        $branch_id = $this->request->queryParams['BalanceSearch']['branch_id'] ?? null;
        $from_data = $this->request->queryParams['BalanceSearch']['from_data'] ?? null;
        $to_data = $this->request->queryParams['BalanceSearch']['to_data'] ?? null;

        $data = Balance::find()
            ->select(['from_data', 'to_data']) // Select only the columns you want
            ->groupBy(['from_data', 'to_data']) // Group by these columns
            ->orderBy(['from_data' => SORT_ASC]) // Group by these columns
            ->asArray() // Return the results as an array
            ->all();

        $dropdownItems = ArrayHelper::map($data, function ($item) {
            return $item['from_data'] . ' : ' . $item['to_data']; // Value
        }, function ($item) {
            return $item['from_data'] . ' : ' . $item['to_data']; // Label
        });

        if ($from_data != null)
            list($from_data, $to_data) = explode(' : ', $from_data);
        else echo "<script>alert('Xatolik: Nolga bo\'lish imkoniyati mavjud.');</script>";

        $aktivlar = $this->aktivlar($branch_id, $from_data, $to_data);

        return $this->render('aktivlar', [
            'model' => $aktivlar,
            'searchModel' => $searchModel,
            'from_data' => $from_data,
            'dropdownItems' => $dropdownItems,
            'to_data' => $to_data,
        ]);
    }

    public function actionMajburiyatlar()
    {
        $searchModel = new BalanceSearch();

        $from_data = $this->request->queryParams['BalanceSearch']['from_data'] ?? null;
        $to_data = $this->request->queryParams['BalanceSearch']['to_data'] ?? null;

        $a = Balance::find()
                ->where(['hisob_raqam_nomi' => 20200])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;

        $a1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 20200])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $b = Balance::find()
                ->where(['hisob_raqam' => 20206])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;

        $b1 = Balance::find()
                ->where(['hisob_raqam' => 20206])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $v = Balance::find()
                ->where(['hisob_raqam_nomi' => 20400])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;

        $v1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 20400])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $g = Balance::find()
                ->where(['hisob_raqam' => 20406])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;

        $g1 = Balance::find()
                ->where(['hisob_raqam' => 20406])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $d = Balance::find()
                ->where(['hisob_raqam_nomi' => 20600])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;
        $d1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 20600])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $e = Balance::find()
                ->where(['hisob_raqam' => 20606])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;
        $e1 = Balance::find()
                ->where(['hisob_raqam' => 20606])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $j = Balance::find()
                ->where(['hisob_raqam_nomi' => 21000])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;
        $j1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 21000])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $yo = Balance::find()
                ->where(['hisob_raqam_nomi' => [21600, 22000]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;
        $yo1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [21600, 22000]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $k = Balance::find()
                ->where(['hisob_raqam_nomi' => 22100])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;
        $k1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 22100])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $l = Balance::find()
                ->where(['hisob_raqam_nomi' => 22200])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;
        $l1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 22200])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $m = Balance::find()
                ->where(['hisob_raqam_nomi' => 22400])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;
        $m1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 22400])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $n = Balance::find()
                ->where(['hisob_raqam_nomi' => 22500])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;
        $n1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 22500])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $o = Balance::find()
                ->where(['hisob_raqam_nomi' => 22600])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;
        $o1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 22600])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $p = Balance::find()
                ->where(['hisob_raqam_nomi' => 23200])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;
        $p1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 23200])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $q = Balance::find()
                ->where(['hisob_raqam_nomi' => 23400])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;
        $q1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 23400])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $r = Balance::find()
                ->where(['hisob_raqam_nomi' => 23100])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;
        $r1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 23100])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $s = Balance::find()
                ->where(['hisob_raqam_nomi' => 23500])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;
        $s1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 23500])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $t = Balance::find()
                ->where(['hisob_raqam_nomi' => [23600, 23700, 22300]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;
        $t1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [23600, 23700, 22300]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $u = Balance::find()
                ->where(['hisob_raqam_nomi' => [29800, 22800]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;
        $u1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [29800, 22800]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $jami_kapital = $a + $v + $d + $j + $yo + $k + $l + $m + $n + $o + $p + $q + $r + $s + $t + $u;
        $jami_kapital1 = $a1 + $v1 + $d1 + $j1 + $yo1 + $k1 + $l1 + $m1 + $n1 + $o1 + $p1 + $q1 + $r1 + $s1 + $t1 + $u1;


        $aktivlar[]["jami_m"] = ['name' => "<b>Талаб қилиб олингунча депозитлар</b>", 'jami_summa' => $a, 'foiz' => $a * 100 / $jami_kapital, 'jami_summa1' => $a1, 'foiz1' => $a1 * 100 / $jami_kapital1, 'farqi' => $a1 - $a];
        $aktivlar[]["jami_m"] = ['name' => "Шундан жисмоний шахсларнинг талаб қилиб олгунча депозитлари", 'jami_summa' => $b, 'foiz' => $b * 100 / $a, 'jami_summa1' => $b1, 'foiz1' => $b1 * 100 / $a1, 'farqi' => $b1 - $b];
        $aktivlar[]["jami_m"] = ['name' => "<b>Жамғарма депозитлар</b>", 'jami_summa' => $v, 'foiz' => $v * 100 / $jami_kapital, 'jami_summa1' => $v1, 'foiz1' => $v1 * 100 / $jami_kapital1, 'farqi' => $v1 - $v];
        $aktivlar[]["jami_m"] = ['name' => "Шундан жисмоний шахсларнинг жамғарма депозитлари", 'jami_summa' => $g, 'foiz' => $g * 100 / $v, 'jami_summa1' => $g1, 'foiz1' => $g1 * 100 / $v1, 'farqi' => $v1 - $v];
        $aktivlar[]["jami_m"] = ['name' => "<b>Муддатли  депозитлар</b>", 'jami_summa' => $d, 'foiz' => $d * 100 / $jami_kapital, 'jami_summa1' => $d1, 'foiz1' => $d1 * 100 / $jami_kapital1, 'farqi' => $d1 - $d];
        $aktivlar[]["jami_m"] = ['name' => "Шундан жисмоний шахсларнинг муддатли депозитлари", 'jami_summa' => $e, 'foiz' => $e * 100 / $d, 'jami_summa1' => $e1, 'foiz1' => $e1 * 100 / $d1, 'farqi' => $e1 - $e];
        $aktivlar[]["jami_m"] = ['name' => "Бошқа банкларга тўланиши лозим бўлган маблағлар", 'jami_summa' => $j, 'foiz' => $j * 100 / $jami_kapital, 'jami_summa1' => $j1, 'foiz1' => $j1 * 100 / $jami_kapital1, 'farqi' => $j1 - $j];
        $aktivlar[]["jami_m"] = ['name' => "Олинган қисқа ва узоқ муддатли ссудалар", 'jami_summa' => $yo, 'foiz' => $yo * 100 / $jami_kapital, 'jami_summa1' => $yo1, 'foiz1' => $yo1 * 100 / $jami_kapital1, 'farqi' => $yo1 - $yo];
        $aktivlar[]["jami_m"] = ['name' => "Лизинг тўловлари бўйича мажбуриятлар", 'jami_summa' => $k, 'foiz' => $k * 100 / $jami_kapital, 'jami_summa1' => $k1, 'foiz1' => $k1 * 100 / $jami_kapital1, 'farqi' => $k1 - $k];
        $aktivlar[]["jami_m"] = ['name' => "Бошқа банк(филиаллар)га тўланган маблағлар", 'jami_summa' => $l, 'foiz' => $l * 100 / $jami_kapital, 'jami_summa1' => $l1, 'foiz1' => $l1 * 100 / $jami_kapital1, 'farqi' => $l1 - $l];
        $aktivlar[]["jami_m"] = ['name' => "Мажбуриятлар бўйича ҳисобланган фоизлар", 'jami_summa' => $m, 'foiz' => $m * 100 / $jami_kapital, 'jami_summa1' => $m1, 'foiz1' => $m1 * 100 / $jami_kapital1, 'farqi' => $m1 - $m];
        $aktivlar[]["jami_m"] = ['name' => "Тўлаш учун ҳисобланган солиқлар", 'jami_summa' => $n, 'foiz' => $n * 100 / $jami_kapital, 'jami_summa1' => $n1, 'foiz1' => $n1 * 100 / $jami_kapital1, 'farqi' => $n1 - $n];
        $aktivlar[]["jami_m"] = ['name' => "Мижозларнинг бошқа депозитлари", 'jami_summa' => $o, 'foiz' => $o * 100 / $jami_kapital, 'jami_summa1' => $o1, 'foiz1' => $o1 * 100 / $jami_kapital1, 'farqi' => $o1 - $o];
        $aktivlar[]["jami_m"] = ['name' => "Клиринг трансакциялари", 'jami_summa' => $p, 'foiz' => $p * 100 / $jami_kapital, 'jami_summa1' => $p1, 'foiz1' => $p1 * 100 / $jami_kapital1, 'farqi' => $p1 - $p];
        $aktivlar[]["jami_m"] = ['name' => "Ҳукуматга тегишли даромад  ва бошқа тушумлар", 'jami_summa' => $q, 'foiz' => $q * 100 / $jami_kapital, 'jami_summa1' => $q1, 'foiz1' => $q1 * 100 / $jami_kapital1, 'farqi' => $q1 - $q];
        $aktivlar[]["jami_m"] = ['name' => "Мижозларнинг пластик карталарига ўтказилиши лозим бўлган маблағлари", 'jami_summa' => $r, 'foiz' => $r * 100 / $jami_kapital, 'jami_summa1' => $r1, 'foiz1' => $r1 * 100 / $jami_kapital1, 'farqi' => $r1 - $r];
        $aktivlar[]["jami_m"] = ['name' => "Хўжалик юритувчи субъектларнинг ва банкнинг транзит ҳисоб рақамларига мижозларнинг пластик карталардан ", 'jami_summa' => $s, 'foiz' => $s * 100 / $jami_kapital, 'jami_summa1' => $s1, 'foiz1' => $s1 * 100 / $jami_kapital1, 'farqi' => $s1 - $s];
        $aktivlar[]["jami_m"] = ['name' => "Чиқарилган жамғарма сертификатлари", 'jami_summa' => $t, 'foiz' => $t * 100 / $jami_kapital, 'jami_summa1' => $t1, 'foiz1' => $t1 * 100 / $jami_kapital1, 'farqi' => $t1 - $t];
        $aktivlar[]["jami_m"] = ['name' => "Бошқа мажбуриятлар", 'jami_summa' => $u, 'foiz' => $u * 100 / $jami_kapital, 'jami_summa1' => $u1, 'foiz1' => $u1 * 100 / $jami_kapital1, 'farqi' => $u1 - $u];
        $aktivlar[]["jami_m"] = ['name' => "<b>Жами мажбуриятлар</b>", 'jami_summa' => $jami_kapital, 'foiz' => 100, 'jami_summa1' => $jami_kapital1, 'foiz1' => 100, 'farqi' => $jami_kapital1 - $jami_kapital];

        return $this->render('majburiyatlar', [
            'model' => $aktivlar,
            'searchModel' => $searchModel,
            'from_data' => $from_data,
            'to_data' => $to_data
        ]);
    }

    public function actionKapital()
    {
        $searchModel = new BalanceSearch();

        $from_data = $this->request->queryParams['BalanceSearch']['from_data'] ?? null;
        $to_data = $this->request->queryParams['BalanceSearch']['to_data'] ?? null;

        $data = Balance::find()
            ->select(['from_data', 'to_data']) // Select only the columns you want
            ->groupBy(['from_data', 'to_data']) // Group by these columns
            ->orderBy(['from_data' => SORT_ASC]) // Group by these columns
            ->asArray() // Return the results as an array
            ->all();

        $dropdownItems = ArrayHelper::map($data, function ($item) {
            return $item['from_data'] . ' : ' . $item['to_data']; // Value
        }, function ($item) {
            return $item['from_data'] . ' : ' . $item['to_data']; // Label
        });

        if ($from_data != null)
            list($from_data, $to_data) = explode(' : ', $from_data);
        else echo "<script>alert('Ehtiyot boling Nolga bo\'lish imkoniyati mavjud.');</script>";

        $aktivlar = $this->kapital($from_data, $to_data);
        return $this->render('kapital', [
            'model' => $aktivlar,
            'searchModel' => $searchModel,
            'from_data' => $from_data,
            'to_data' => $to_data,
            'dropdownItems' => $dropdownItems,
        ]);
    }

    public function actionSmeta()
    {
        $searchModel = new BalanceSearch();

        $from_data = $this->request->queryParams['BalanceSearch']['from_data'] ?? null;
        $to_data = $this->request->queryParams['BalanceSearch']['to_data'] ?? null;

        $data = Balance::find()
            ->select(['from_data', 'to_data']) // Select only the columns you want
            ->groupBy(['from_data', 'to_data']) // Group by these columns
            ->orderBy(['from_data' => SORT_ASC]) // Group by these columns
            ->asArray() // Return the results as an array
            ->all();

        $dropdownItems = ArrayHelper::map($data, function ($item) {
            return $item['from_data'] . ' : ' . $item['to_data']; // Value
        }, function ($item) {
            return $item['from_data'] . ' : ' . $item['to_data']; // Label
        });

        $a = Balance::find()
                ->where(['hisob_raqam_nomi' => [40200, 40400, 40600, 40700, 40800, 41000, 41200, 41400, 41600, 41800, 41900, 42000, 42100, 42200, 42300, 42400, 42500, 42600, 43600, 43700, 43900, 44000, 44100, 44200, 44300, 44400, 44500, 44600, 44700, 44800, 44900, 45100]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;

        $a1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [40200, 40400, 40600, 40700, 40800, 41000, 41200, 41400, 41600, 41800, 41900, 42000, 42100, 42200, 42300, 42400, 42500, 42600, 43600, 43700, 43900, 44000, 44100, 44200, 44300, 44400, 44500, 44600, 44700, 44800, 44900, 45100]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $b = Balance::find()
                ->where(['hisob_raqam_nomi' => [45200, 45400, 45600, 45700, 45800, 45900]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_passiv') ?? 0;

        $b1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [45200, 45400, 45600, 45700, 45800, 45900]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_passiv') ?? 0;

        $jami_daromad = $a + $b;
        $jami_daromad1 = $a1 + $b1;

        $c = Balance::find()
                ->where(['hisob_raqam_nomi' => [50100, 50600, 51100, 51600, 52100, 52600, 53100, 54100, 54200, 54300, 54900]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $c1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [50100, 50600, 51100, 51600, 52100, 52600, 53100, 54100, 54200, 54300, 54900]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $d = Balance::find()
                ->where(['hisob_raqam_nomi' => [55100, 55300, 55600, 55700, 55800, 55900]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $d1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [55100, 55300, 55600, 55700, 55800, 55900]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $e = Balance::find()
                ->where(['hisob_raqam_nomi' => 56100])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $e1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [56100]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $f = Balance::find()
                ->where(['hisob_raqam_nomi' => 56200])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $f1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [56200]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $g = Balance::find()
                ->where(['hisob_raqam_nomi' => 56300])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $g1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [56300]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $h = Balance::find()
                ->where(['hisob_raqam_nomi' => 56400])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $h1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [56400]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $i = Balance::find()
                ->where(['hisob_raqam_nomi' => 56500])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $i1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [56500]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $j = Balance::find()
                ->where(['hisob_raqam_nomi' => 56600])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $j1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [56600]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $k = Balance::find()
                ->where(['hisob_raqam_nomi' => 56700])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $k1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [56700]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $l = Balance::find()
                ->where(['hisob_raqam_nomi' => 56800])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $l1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [56800]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $m = Balance::find()
                ->where(['hisob_raqam_nomi' => 56900])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $m1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [56900]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $operatsion_xarajatlar = $e + $f + $g + $h + $i + $j + $k;
        $operatsion_xarajatlar1 = $e1 + $f1 + $g1 + $h1 + $i1 + $j1 + $k1;

        $jami_xarajat = $c + $d + $operatsion_xarajatlar + $l + $m;
        $jami_xarajat1 = $c1 + $d1 + $operatsion_xarajatlar1 + $l1 + $m1;

        $jami_foyda = $jami_daromad - $jami_xarajat;
        $jami_foyda1 = $jami_daromad1 - $jami_xarajat1;

        $undurilmagan = Balance::find()
                ->where(['hisob_raqam_nomi' => [16300, 16400]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $undurilmagan1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [16300, 16400]])
                ->andFilterWhere([
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $real_foyda = $jami_foyda - $undurilmagan;
        $real_foyda1 = $jami_foyda1 - $undurilmagan1;

        $xarajat_daromad = $jami_xarajat * 100000 / $jami_daromad;
        $xarajat_daromad1 = $jami_xarajat1 * 100000 / $jami_daromad1;

        $aktivlar[]["jami_m"] = ['name' => "Фоизли даромадлар", $a, 'foiz' => $a * 100 / $jami_daromad, 'jami_summa1' => $a1, 'foiz1' => $a1 * 100 / $jami_daromad1, 'farqi' => $a1 - $a];
        $aktivlar[]["jami_m"] = ['name' => "Фоизсиз даромадлар", $b, 'foiz' => $b * 100 / $jami_daromad, 'jami_summa1' => $b1, 'foiz1' => $b1 * 100 / $jami_daromad1, 'farqi' => $b1 - $b];
        $aktivlar[]["jami_m"] = ['name' => "<b>Жами даромад</b>", $jami_daromad, 'foiz' => 100, 'jami_summa1' => $jami_daromad1, 'foiz1' => 100, 'farqi' => $jami_daromad1 - $jami_daromad];
        $aktivlar[]["jami_m"] = ['name' => "Фоизли харажатлар", $c, 'foiz' => $c * 100 / $jami_xarajat, 'jami_summa1' => $c1, 'foiz1' => $c1 * 100 / $jami_xarajat1, 'farqi' => $c1 - $c];
        $aktivlar[]["jami_m"] = ['name' => "Фоизсиз харажатлар", $d, 'foiz' => $d * 100 / $jami_xarajat, 'jami_summa1' => $d1, 'foiz1' => $d1 * 100 / $jami_xarajat1, 'farqi' => $c1 - $c];
        $aktivlar[]["jami_m"] = ['name' => "Операцион харажатлар", $operatsion_xarajatlar, 'foiz' => $operatsion_xarajatlar * 100 / $jami_xarajat, 'jami_summa1' => $operatsion_xarajatlar1, 'foiz1' => $operatsion_xarajatlar1 * 100 / $jami_xarajat1, 'farqi' => $operatsion_xarajatlar1 - $operatsion_xarajatlar];
        $aktivlar[]["jami_m"] = ['name' => "Шундан:", 0, 'foiz' => 0, 'jami_summa1' => 0, 'foiz1' => 0, 'farqi' => 0];
        $aktivlar[]["jami_m"] = ['name' => "Иш  хақи", $e, 'foiz' => $e * 100 / $jami_xarajat, 'jami_summa1' => $e1, 'foiz1' => $e1 * 100 / $jami_xarajat1, 'farqi' => $e1 - $e];
        $aktivlar[]["jami_m"] = ['name' => "Ижара ва сақлаш харажати", $f, 'foiz' => $f * 100 / $jami_xarajat, 'jami_summa1' => $f1, 'foiz1' => $f1 * 100 / $jami_xarajat1, 'farqi' => $f1 - $f];
        $aktivlar[]["jami_m"] = ['name' => "Транспорт ва сафар харажатлари", $g, 'foiz' => $g * 100 / $jami_xarajat, 'jami_summa1' => $g1, 'foiz1' => $g1 * 100 / $jami_xarajat1, 'farqi' => $g1 - $g];
        $aktivlar[]["jami_m"] = ['name' => "Маъмурий харажатлар", $h, 'foiz' => $h * 100 / $jami_xarajat, 'jami_summa1' => $h1, 'foiz1' => $h1 * 100 / $jami_xarajat1, 'farqi' => $h1 - $h];
        $aktivlar[]["jami_m"] = ['name' => "Тақдимот ва хайрия", $i, 'foiz' => $i * 100 / $jami_xarajat, 'jami_summa1' => $i1, 'foiz1' => $i1 * 100 / $jami_xarajat1, 'farqi' => $i1 - $i];
        $aktivlar[]["jami_m"] = ['name' => "Эскириш харажатлари", $j, 'foiz' => $j * 100 / $jami_xarajat, 'jami_summa1' => $j1, 'foiz1' => $j1 * 100 / $jami_xarajat1, 'farqi' => $j1 - $j];
        $aktivlar[]["jami_m"] = ['name' => "Суғурта, солиқ ва бошқа хар.", $k, 'foiz' => $k * 100 / $jami_xarajat, 'jami_summa1' => $k1, 'foiz1' => $k1 * 100 / $jami_xarajat1, 'farqi' => $k1 - $k];
        $aktivlar[]["jami_m"] = ['name' => "Келгуси  зарарларни баҳолаш", $l, 'foiz' => $l * 100 / $jami_xarajat, 'jami_summa1' => $l1, 'foiz1' => $l1 * 100 / $jami_xarajat1, 'farqi' => $l1 - $l];
        $aktivlar[]["jami_m"] = ['name' => "Даромад  солиғи", $m, 'foiz' => $m * 100 / $jami_xarajat, 'jami_summa1' => $m1, 'foiz1' => $m1 * 100 / $jami_xarajat1, 'farqi' => $m1 - $m];
        $aktivlar[]["jami_m"] = ['name' => "<b>Жами  харажатлар</b>", $jami_xarajat, 'foiz' => 100, 'jami_summa1' => $jami_xarajat1, 'foiz1' => 100, 'farqi' => $jami_xarajat1 - $jami_xarajat];
        $aktivlar[]["jami_m"] = ['name' => "<b>Фойда</b>", $jami_foyda, 'foiz' => 100, 'jami_summa1' => $jami_foyda1, 'foiz1' => 100, 'farqi' => $jami_foyda1 - $jami_foyda];
        $aktivlar[]["jami_m"] = ['name' => "<b>Ҳисобланган, лекин ундирилмаган фоиз ва хизматлар</b>", $undurilmagan, 'foiz' => 100, 'jami_summa1' => $undurilmagan1, 'foiz1' => 100, 'farqi' => $undurilmagan1 - $undurilmagan];
        $aktivlar[]["jami_m"] = ['name' => "<b>Реал  соф  фойда</b>", $real_foyda, 'foiz' => $real_foyda * 100 / $jami_foyda, 'jami_summa1' => $real_foyda1, 'foiz1' => $real_foyda1 * 100 / $jami_foyda1, 'farqi' => $real_foyda1 - $real_foyda];
        $aktivlar[]["jami_m"] = ['name' => "<b>Харажатнинг даромаддаги улуши</b>", $xarajat_daromad, 'foiz' => $real_foyda * 100 / $jami_foyda, 'jami_summa1' => $xarajat_daromad1, 'foiz1' => $real_foyda1 * 100 / $jami_foyda1, 'farqi' => $xarajat_daromad1 - $xarajat_daromad];

        return $this->render('smeta', [
            'model' => $aktivlar,
            'searchModel' => $searchModel,
            'from_data' => $from_data,
            'to_data' => $to_data,
            'dropdownItems' => $dropdownItems,
        ]);
    }

    public function actionDoc()
    {
        $searchModel = new BalanceSearch();

        $from_data = $this->request->queryParams['BalanceSearch']['from_data'] ?? null;
        $to_data = $this->request->queryParams['BalanceSearch']['to_data'] ?? null;

        $data = Balance::find()
            ->select(['from_data', 'to_data']) // Select only the columns you want
            ->groupBy(['from_data', 'to_data']) // Group by these columns
            ->orderBy(['from_data' => SORT_ASC]) // Group by these columns
            ->asArray() // Return the results as an array
            ->all();

        $dropdownItems = ArrayHelper::map($data, function ($item) {
            return $item['from_data'] . ' : ' . $item['to_data']; // Value
        }, function ($item) {
            return $item['from_data'] . ' : ' . $item['to_data']; // Label
        });

        if ($from_data != null)
            list($from_data, $to_data) = explode(' : ', $from_data);
        else echo "<script>alert('Xatolik: Nolga bo\'lish imkoniyati mavjud.');</script>";

        $aktivlar = $this->kapital($from_data, $to_data);
        echo "pre";
        print_r($aktivlar);
    }

    public function aktivlar($branch_id, $from_data, $to_data)
    {
        $a = Balance::find()
                ->where(['hisob_raqam' => 11100])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $a1 = Balance::find()
                ->where(['hisob_raqam' => 11100])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $b = Balance::find()
                ->where(['hisob_raqam_nomi' => [12600, 12100, 12300, 12400, 12500, 12700, 12900, 13000, 13100, 13200, 13300]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $b1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [12600, 12100, 12300, 12400, 12500, 12700, 12900, 13000, 13100, 13200, 13300]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;


        $v = Balance::find()
                ->where(['hisob_raqam_nomi' => [14300, 14500, 14700, 14900, 15000, 15100, 15200, 15300, 15400, 15500, 14800]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $v1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [14300, 14500, 14700, 14900, 15000, 15100, 15200, 15300, 15400, 15500, 14800]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $g = 0;
        $g1 = 0;

        $d = Balance::find()
                ->where(['hisob_raqam_nomi' => 15700])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $d1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 15700])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $e = Balance::find()
                ->where(['hisob_raqam_nomi' => 15900])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $e1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 15900])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $j = Balance::find()
                ->where(['hisob_raqam_nomi' => 15800])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $j1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 15800])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $yo = Balance::find()
                ->where(['hisob_raqam' => [16101, 16102]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $yo1 = Balance::find()
                ->where(['hisob_raqam' => [16101, 16102]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_a = Balance::find()
                ->where(['hisob_raqam' => [16104, 16105, 16107, 16109]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $_a1 = Balance::find()
                ->where(['hisob_raqam' => [16104, 16105, 16107, 16109]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_b = Balance::find()
                ->where(['hisob_raqam_nomi' => [16300, 16400]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $_b1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [16300, 16400]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_v = Balance::find()
                ->where(['hisob_raqam_nomi' => [16500, 16600, 16700]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $_v1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [16500, 16600, 16700]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_g = Balance::find()
                ->where(['hisob_raqam_nomi' => [17100]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $_g1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [17100]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_d = Balance::find()
                ->where(['hisob_raqam_nomi' => [17300, 17400]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $_d1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [17300, 17400]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_e = Balance::find()
                ->where(['hisob_raqam_nomi' => [17500, 10700, 10800]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $_e1 = Balance::find()
                ->where(['hisob_raqam_nomi' => [17500, 10700, 10800]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_j = Balance::find()
                ->where(['hisob_raqam_nomi' => 19900])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $_j1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 19900])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $shundan1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 10100])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $shundan1 = $shundan1 - Balance::find()
                ->where(['hisob_raqam' => 10109])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $shundan1_2 = Balance::find()
                ->where(['hisob_raqam_nomi' => 10100])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;
        $shundan1_2 = $shundan1_2 - Balance::find()
                ->where(['hisob_raqam' => 10109])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;


        $shundan2 = Balance::find()
                ->where(['hisob_raqam_nomi' => [10300, 10500]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $shundan2 += Balance::find()
                ->where(['hisob_raqam' => [10109]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $shundan2 = $shundan2 - Balance::find()
                ->where(['hisob_raqam' => [10309]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;

        $shundan2_2 = Balance::find()
                ->where(['hisob_raqam_nomi' => [10300, 10500]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;
        $shundan2_2 += Balance::find()
                ->where(['hisob_raqam' => [10109]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $shundan2_2 = $shundan2_2 - Balance::find()
                ->where(['hisob_raqam' => [10309]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $shundan3 = Balance::find()
                ->where(['hisob_raqam' => [10309]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $shundan3_2 = Balance::find()
                ->where(['hisob_raqam' => [10309]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $shundan4 = Balance::find()
                ->where(['hisob_raqam' => [16103]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $shundan4_2 = Balance::find()
                ->where(['hisob_raqam' => [16103]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $shundan5 = Balance::find()
                ->where(['hisob_raqam' => [16113, 16111]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('kirim_aktiv') ?? 0;
        $shundan5_2 = Balance::find()
                ->where(['hisob_raqam' => [16113, 16111]])
                ->andFilterWhere([
                    'branch_id' => $branch_id,
                    'from_data' => $from_data,
                    'to_data' => $to_data,
                ])
                ->sum('chiqim_aktiv') ?? 0;

        $_yo = $shundan1 + $shundan2 + $shundan3 + $shundan4 + $shundan5;
        $_yo1 = $shundan1_2 + $shundan2_2 + $shundan3_2 + $shundan4_2 + $shundan5_2;

        $daromad = $a + $b + $v + $g + $d + $e + $j + $yo;
        $daromad1 = $a1 + $b1 + $v1 + $g1 + $d1 + $e1 + $j1 + $yo1;

        $daromad_emas = $_a + $_b + $_v + $_g + $_d + $_e + $_j + $_yo;
        $daromad_emas1 = $_a1 + $_b1 + $_v1 + $_g1 + $_d1 + $_e1 + $_j1 + $_yo1;

        $all = [
            'daromad' => $daromad,
            'daromad1' => $daromad1,
            'daromad_emas' => $daromad_emas,
            'daromad_emas1' => $daromad_emas1,
            'jami1' => $daromad_emas + $daromad,
            'jami2' => $daromad_emas1 + $daromad1
        ];
        try {
            if ($daromad === 0 || $daromad_emas === 0 || $daromad1 === 0 || $daromad_emas1 === 0)
            {
                throw new DivisionByZeroError("Daromad va daromad emas 0 ga teng bo'lishi mumkin emas.");
                die();
            }
            $aktivlar[]["jami_a"] = ['name' => "<b>Даромад келтирувчи активлар</b>", 'jami_summa1' => $daromad, 'jami_foiz1' => $daromad * 100 / ($daromad + $daromad_emas), 'jami_summa2' => $daromad1, 'foiz2' => $daromad1 * 100 / ($daromad1 + $daromad_emas1), 'farqi' => $daromad1 - $daromad];
            $aktivlar[]["a"] = ['name' => "- факторинг", 'summa1' => $a, 'foiz1' => $a * 100 / $daromad, 'summa2' => $a1, 'foiz2' => $a1 * 100 / $daromad1, 'farqi' => $a1 - $a];
            $aktivlar[]["b"] = ['name' => "- қисқа муддатли ва муддати утган ссудалар", 'summa1' => $b, 'foiz1' => $b * 100 / $daromad, 'summa2' => $b1, 'foiz2' => $b1 * 100 / $daromad1, 'farqi' => $b1 - $b];
            $aktivlar[]["v"] = ['name' => "- узоқ муддатли ссудалар", 'summa1' => $v, 'foiz1' => $v * 100 / $daromad, 'summa2' => $v1, 'foiz2' => $v1 * 100 / $daromad1, 'farqi' => $v1 - $v];
            $aktivlar[]["g"] = ['name' => "- лизинг", 'summa1' => $g, 'foiz1' => $g * 100 / $daromad, 'summa2' => $g1, 'foiz2' => $g1 * 100 / $daromad1, 'farqi' => $g1 - $g];
            $aktivlar[]["d"] = ['name' => "- суд жараёнидаги кредитлар ва лизинг", 'summa1' => $d, 'foiz1' => $d * 100 / $daromad, 'summa2' => $d1, 'foiz2' => $g1 * 100 / $daromad1, 'farqi' => $d1 - $d];
            $aktivlar[]["e"] = ['name' => "- сўндириш муддатигача сакланадиган карз кимматли когозларга килинган инвестициялар", 'summa1' => $e, 'foiz1' => $e * 100 / $daromad, 'summa2' => $e1, 'foiz2' => $e1 * 100 / $daromad1, 'farqi' => $e1 - $e];
            $aktivlar[]["j"] = ['name' => "- қўшма корхоналарга инвестиция", 'summa1' => $j, 'foiz1' => $j * 100 / $daromad, 'summa2' => $j1, 'foiz2' => $j1 * 100 / $daromad1, 'farqi' => $j1 - $j];
            $aktivlar[]["yo"] = ['name' => "- банк филиалларига берилган молиявий ёрдам ва ресурслар", 'summa1' => $yo, 'foiz1' => $yo * 100 / $daromad, 'summa2' => $yo1, 'foiz2' => $yo1 * 100 / $daromad1, 'farqi' => $yo1 - $yo];

            $aktivlar[]["jami_a"] = ['name' => "<b>Даромад келтирмайдиган активлар</b>", 'jami_summa1' => $daromad_emas, 'jami_foiz1' => $daromad_emas * 100 / ($daromad + $daromad_emas), 'jami_summa2' => $daromad_emas1, 'foiz2' => $daromad_emas1 * 100 / ($daromad1 + $daromad_emas1), 'farqi' => $daromad_emas1 - $daromad_emas];
            $aktivlar[]["a"] = ['name' => "- бош офисдан товар материал олиш учун ўтказилган маблағлар", 'summa1' => $_a, 'foiz1' => $_a * 100 / $daromad_emas, 'summa2' => $_a1, 'foiz2' => $_a1 * 100 / $daromad_emas1, 'farqi' => $_a1 - $_a];
            $aktivlar[]["b"] = ['name' => "- ҳисобланган, лекин ундирилмаган фоизлар", 'summa1' => $_b, 'foiz1' => $_b * 100 / $daromad_emas, 'summa2' => $_b1, 'foiz2' => $_b1 * 100 / $daromad_emas1, 'farqi' => $_b1 - $_b];
            $aktivlar[]["v"] = ['name' => "- банк мулклари", 'summa1' => $_v, 'foiz1' => $_v * 100 / $daromad_emas, 'summa2' => $_v1, 'foiz2' => $_v1 * 100 / $daromad_emas1, 'farqi' => $_v1 - $_v];
            $aktivlar[]["g"] = ['name' => "- чет эл валюталарининг сўмдаги қиймати", 'summa1' => $_g, 'foiz1' => $_g * 100 / $daromad_emas, 'summa2' => $_g1, 'foiz2' => $_g1 * 100 / $daromad_emas1, 'farqi' => $_g1 - $_g];
            $aktivlar[]["d"] = ['name' => "- транзит счетлар", 'summa1' => $_d, 'foiz1' => $_d * 100 / $daromad_emas, 'summa2' => $_d1, 'foiz2' => $_g1 * 100 / $daromad_emas1, 'farqi' => $_d1 - $_d];
            $aktivlar[]["e"] = ['name' => "- давлат ҳисоб рақамлари", 'summa1' => $_e, 'foiz1' => $_e * 100 / $daromad_emas, 'summa2' => $_e1, 'foiz2' => $_e1 * 100 / $daromad_emas1, 'farqi' => $_e1 - $_e];
            $aktivlar[]["j"] = ['name' => "- бошқа активлар", 'summa1' => $_j, 'foiz1' => $_j * 100 / $daromad_emas, 'summa2' => $_j1, 'foiz2' => $_j1 * 100 / $daromad_emas1, 'farqi' => $_j1 - $_j];
            $aktivlar[]["yo"] = ['name' => "- юқори ликвидли активлар", 'summa1' => $_yo, 'foiz1' => $_yo * 100 / $daromad_emas, 'summa2' => $_yo1, 'foiz2' => $_yo1 * 100 / $daromad_emas1, 'farqi' => $_yo1 - $_yo];
            $aktivlar[]["shundan1"] = ['name' => "   - кассадаги нақд пуллар ва қимматбаҳо металлар", 'summa1' => $shundan1, 'foiz1' => $shundan1 * 100 / $daromad_emas, 'summa2' => $shundan1_2, 'foiz2' => $shundan1_2 * 100 / $daromad_emas1, 'farqi' => $shundan1_2 - $shundan1];
            $aktivlar[]["shundan2"] = ['name' => "   - йўлдаги пуллар", 'summa1' => $shundan2, 'foiz1' => $shundan2 * 100 / $daromad_emas, 'summa2' => $shundan2_2, 'foiz2' => $shundan2_2 * 100 / $daromad_emas1, 'farqi' => $shundan2_2 - $shundan2];
            $aktivlar[]["shundan3"] = ['name' => "   - мажбурий заҳира фондидаги маблағлар", 'summa1' => $shundan3, 'foiz1' => $shundan3 * 100 / $daromad_emas, 'summa2' => $shundan3_2, 'foiz2' => $shundan3_2 * 100 / $daromad_emas1, 'farqi' => $shundan3_2 - $shundan3];
            $aktivlar[]["shundan4"] = ['name' => "   - ягона вакиллик ҳисобварағидаги маблағлар", 'summa1' => $shundan4, 'foiz1' => $shundan4 * 100 / $daromad_emas, 'summa2' => $shundan4_2, 'foiz2' => $shundan4_2 * 100 / $daromad_emas1, 'farqi' => $shundan4_2 - $shundan4];
            $aktivlar[]["shundan5"] = ['name' => "   -паластик картлардан амалга оширилган туловлар буйича бошка банклардан олинадиган маблаглар", 'summa1' => $shundan5, 'foiz1' => $shundan5 * 100 / $daromad_emas, 'summa2' => $shundan5_2, 'foiz2' => $shundan5_2 * 100 / $daromad_emas1, 'farqi' => $shundan5_2 - $shundan5];

            $aktivlar['Даромад эмас']["jami"] = [
                'name' => "<b>Жами активлар</b>", 'summa1' => $daromad_emas + $daromad,
                'foiz1' => $daromad * 100 / ($daromad + $daromad_emas) + $daromad_emas * 100 / ($daromad + $daromad_emas),
                'summa2' => $daromad_emas1 + $daromad1,
                'foiz2' => $daromad_emas1 * 100 / ($daromad1 + $daromad_emas1) + $daromad1 * 100 / ($daromad1 + $daromad_emas1),
                'farqi' => (($daromad_emas1 + $daromad1) - ($daromad_emas + $daromad))
            ];
        } catch (DivisionByZeroError $e) {
            echo "<script>alert('Xatolik: Nolga bo\'lish imkoniyati mavjud.');</script>";
            return $this->redirect('http://audit.ingo.uz/finance/aktivlar'); die();
        }catch (Exception $e) {
            // Boshqa istisnolarni ushlash
            echo "Umumiy xato: " . $e->getMessage();
        }
        return $aktivlar;
    }

    public function kapital($from_data, $to_data)
    {
        $a = Balance::find()
                ->where(['hisob_raqam_nomi' => 30300])
                ->andFilterWhere(['from_data' => $from_data, 'to_data' => $to_data])
                ->sum('kirim_passiv') ?? 0;

        $a1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 30300])
                ->andFilterWhere(['from_data' => $from_data, 'to_data' => $to_data])
                ->sum('chiqim_passiv') ?? 0;

        $b = Balance::find()
                ->where(['hisob_raqam' => 30600])
                ->andFilterWhere(['from_data' => $from_data, 'to_data' => $to_data])
                ->sum('kirim_passiv') ?? 0;

        $b1 = Balance::find()
                ->where(['hisob_raqam' => 30600])
                ->andFilterWhere(['from_data' => $from_data, 'to_data' => $to_data])
                ->sum('chiqim_passiv') ?? 0;

        $v = Balance::find()
                ->where(['hisob_raqam_nomi' => 30900])
                ->andFilterWhere(['from_data' => $from_data, 'to_data' => $to_data])
                ->sum('kirim_passiv') ?? 0;

        $v1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 30900])
                ->andFilterWhere(['from_data' => $from_data, 'to_data' => $to_data])
                ->sum('chiqim_passiv') ?? 0;

        $g = Balance::find()
                ->where(['hisob_raqam_nomi' => 31200])
                ->andFilterWhere(['from_data' => $from_data, 'to_data' => $to_data])
                ->sum('kirim_passiv') ?? 0;

        $g1 = Balance::find()
                ->where(['hisob_raqam_nomi' => 31200])
                ->andFilterWhere(['from_data' => $from_data, 'to_data' => $to_data])
                ->sum('chiqim_passiv') ?? 0;

        // Jami kapital hisoblash
        $jami_kapital = $a + $b + $v + $g;
        $jami_kapital1 = $a1 + $b1 + $v1 + $g1;
        try {
            // Aktivlar massivi
            $aktivlar = [];
            $aktivlar[] = [
                "jami_m" => [
                    'name' => "Акционерлик капитали",
                    'jami_summa' => $a,
                    'foiz' => $jami_kapital ? ($a * 100 / $jami_kapital) : 0,
                    'jami_summa1' => $a1,
                    'foiz1' => $jami_kapital1 ? ($a1 * 100 / $jami_kapital1) : 0,
                    'farqi' => $a1 - $a
                ]
            ];
            $aktivlar[] = [
                "jami_m" => [
                    'name' => "Қўшимча капитал",
                    'jami_summa' => $b,
                    'foiz' => $jami_kapital ? ($b * 100 / $jami_kapital) : 0,
                    'jami_summa1' => $b1,
                    'foiz1' => $jami_kapital1 ? ($b1 * 100 / $jami_kapital1) : 0,
                    'farqi' => $b1 - $b
                ]
            ];
            $aktivlar[] = [
                "jami_m" => [
                    'name' => "Заҳира капитали",
                    'jami_summa' => $v,
                    'foiz' => $jami_kapital ? ($v * 100 / $jami_kapital) : 0,
                    'jami_summa1' => $v1,
                    'foiz1' => $jami_kapital1 ? ($v1 * 100 / $jami_kapital1) : 0,
                    'farqi' => $v1 - $v
                ]
            ];
            $aktivlar[] = [
                "jami_m" => [
                    'name' => "Тақсимланмаган фойда",
                    'jami_summa' => $g,
                    'foiz' => $jami_kapital ? ($g * 100 / $jami_kapital) : 0,
                    'jami_summa1' => $g1,
                    'foiz1' => $jami_kapital1 ? ($g1 * 100 / $jami_kapital1) : 0,
                    'farqi' => $g1 - $g
                ]
            ];
            $aktivlar[] = [
                "jami_m" => [
                    'name' => "<b>Жами  капитал</b>",
                    'jami_summa' => $jami_kapital,
                    'foiz' => 100,
                    'jami_summa1' => $jami_kapital1,
                    'foiz1' => 100,
                    'farqi' => $jami_kapital1 - $jami_kapital
                ]
            ];
        } catch (DivisionByZeroError $e) {
            echo "<script>alert('Xatolik: Nolga bo\'lish imkoniyati mavjud.');</script>";
            return $this->redirect('http://audit.ingo.uz/finance/kapital');
        }

        return $aktivlar;
    }

}

?>