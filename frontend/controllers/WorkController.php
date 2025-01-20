<?php

namespace frontend\controllers;

use app\models\AuthAssignment;
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
use frontend\models\Worklist;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * WorkController implements the CRUD actions for Work model.
 */
class WorkController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $role = AuthAssignment::findOne(['user_id' => $user_id]);
            $role = $role->item_name ? $role->item_name : 0;
            if ($role === 'Administrator') {
                $this->layout = 'main';
            }
            if ($role === 'admin_audit') {
                $this->layout = 'main';
            }
            if ($role === 'auditor') {
                $this->layout = 'auditors';
            }
            if ($role === 'departaments') {
                $this->layout = 'departaments';
            }
            if ($role === 'monitoring') {
                $this->layout = 'main';
            }
        }
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                        'qabul' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionIndex()
    {
        $searchModel = new WorkSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $doc_log = new DocLog();
        $doc_log->work_id = $id;
        $doc_log->user_id = Yii::$app->user->id;
        $doc_log->status_old = $model->work_status;
        $doc_log->status_new = $model->work_status;
        $doc_log->action = "ko`rish";
        $doc_log->ip = Yii::$app->request->userIP;
        $doc_log->save();
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionWorklistview($work_id)
    {
        $xabar = new Xabar();

        if ($xabar->load($this->request->post())) {
            $xabar->work_id = $work_id;
            if ($xabar->save())
                $model = $this->findModel($work_id);
            $work_status = $model->work_status;
            $model->work_status = '4';

            $worklist = Worklist::find()
                ->where(['work_id' => $work_id])
                ->orderBy(['id' => SORT_DESC]) // ketma-ketlik bo'yicha tartiblash
                ->one();
            $worklist->status = 4;

            if ($model->save() && $worklist->save()) {
                $doc_log = new DocLog();
                $doc_log->work_id = $work_id;
                $doc_log->user_id = Yii::$app->user->id;
                $doc_log->status_old = $work_status;
                $doc_log->status_new = $model->work_status;
                $doc_log->action = "Rad";
                $doc_log->ip = Yii::$app->request->userIP;
                $doc_log->save();
                return $this->redirect(['work/view','id'=>$work_id]);
            }

            $model->work_status = $work_status;
            return $this->render('work/worklistview', [
                'model' => $model,
            ]);
        }

        return $this->render('worklistview', [
            'model' => $this->findModelworklist($work_id),
            'xabar' => $xabar,
        ]);
    }

    public function actionCreate()
    {
        $model = new Work();

        if ($this->request->isPost) {
            $model->user_id = Yii::$app->user->id;

            if ($model->load($this->request->post())) {
                if ($model->unical === '') $model->unical = 0;
                if ($model->hisob_raqam === '') $model->hisob_raqam = 0;
                if ($model->bartaraf_soni === '') $model->bartaraf_soni = 0;
                $model->mistake_sum = str_replace(" ", "", $model->mistake_sum);

                $farmoyish_id = $model->farmoyish_id;
                $region_id = $model->region_id;
                $branche_id = $model->branch_id;
                $year = $model->year;
                $unical = $model->unical;
                $hisob_raqam = $model->hisob_raqam;
                $client = $model->client_name;
                $head_mistake = $model->head_mistakes_group_code;
                $status = Mistakes::findOne(['code' => $model->mistake_code])->status;
                $soni = $model->mistake_soni;
                $mistake_sum = $model->mistake_sum;
                $mistake_from = $model->mistak_from_user;
                $user_id = $model->user_id;
                $dep_id = $model->departament_id;
                $comment = $model->comment;
                $work_status = $model->work_status;
                $bartaraf_soni = 0;

                $code = $model->mistake_code;
//----------------------------------------------------------------------------------------------------------------------
                foreach ($code as $item) {
                    $model = new Work();
                    $model->farmoyish_id = $farmoyish_id;
                    $model->region_id = $region_id;
                    $model->branch_id = $branche_id;
                    $model->year = $year;
                    $model->unical = $unical;
                    $model->hisob_raqam = $hisob_raqam;
                    $model->client_name = $client;
                    $model->head_mistakes_group_code = $head_mistake;
                    $model->mistake_code = $item;
                    $model->status = Mistakes::findOne(['code' => $item])->status;
                    $model->mistake_soni = $soni;
                    $model->mistake_sum = $mistake_sum;
                    $model->mistak_from_user = $mistake_from;
                    $model->user_id = $user_id;
                    $model->departament_id = $dep_id;
                    $model->comment = $comment;
                    $model->work_status = 0;
                    $model->bartaraf_soni = $bartaraf_soni;
                    $model->uzlashtirish = Mistakes::findOne($item)->uzlashtirish;

                    if ($model->save()) {
                        $doc_log = new DocLog();
                        $doc_log->work_id = Work::find()->max('id');
                        $doc_log->user_id = $user_id;
                        $doc_log->status_old = 0;
                        $doc_log->status_new =0;
                        $doc_log->action = "yaratildi";
                        $doc_log->ip = Yii::$app->request->userIP;
                        $doc_log->save();
                    } else {
                        var_dump($model->errors);
                        die("Xato");
                    }

                }
                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        $regions = Regions::find()->all();
        $branches = Branches::find()->all();

        return $this->render('create', [
            'model' => $model,
            'regions' => $regions,
            'branches' => $branches,
        ]);
    }

    public function actionCreate2()
    {

        $model = new Work();
        die('vaqtincha toxtatilgan');
        if ($this->request->isPost) {
            $model->user_id = Yii::$app->user->id;

            if ($model->load($this->request->post())) {
                if ($model->unical === '') $model->unical = 0;
                if ($model->hisob_raqam === '') $model->hisob_raqam = 0;
                if ($model->bartaraf_soni === '') $model->bartaraf_soni = 0;
                $model->mistake_sum = str_replace(" ", "", $model->mistake_sum);

                $farmoyish_id = $model->farmoyish_id;
                $region_id = $model->region_id;
                $branche_id = $model->branch_id;
                $year = $model->year;
                $unical = $model->unical;
                $hisob_raqam = $model->hisob_raqam;
                $client = $model->client_name;
                $head_mistake = $model->head_mistakes_group_code;
                $status = $model->status;
                $soni = $model->mistake_soni;
                $mistake_sum = $model->mistake_sum;
                $mistake_from = $model->mistak_from_user;
                $user_id = $model->user_id;
                $dep_id = $model->departament_id;
                $comment = $model->comment;
                $work_status = $model->work_status;
                $bartaraf_soni = $model->bartaraf_soni;


                $code = $model->mistake_code;
//----------------------------------------------------------------------------------------------------------------------
                $model = new Work();
                $model->farmoyish_id = $farmoyish_id;
                $model->region_id = $region_id;
                $model->branch_id = $branche_id;
                $model->year = $year;
                $model->unical = $unical;
                $model->hisob_raqam = $hisob_raqam;
                $model->client_name = $client;
                $model->head_mistakes_group_code = $head_mistake;
                $model->mistake_code = $code;
                $model->status = Mistakes::findOne(['code' => $code])->status;
                $model->mistake_soni = $soni;
                $model->mistake_sum = $mistake_sum;
                $model->mistak_from_user = $mistake_from;
                $model->user_id = $user_id;
                $model->departament_id = $dep_id;
                $model->comment = $comment;
                $model->work_status = 3;
                $model->bartaraf_soni = $bartaraf_soni;


                if ($model->save()) {
                    $doc_log = new DocLog();
                    $doc_log->work_id = Work::find()->max('id');
                    $doc_log->user_id = $user_id;
                    $doc_log->status_old = 0;
                    $doc_log->status_new = 0;
                    $doc_log->action = "yaratildi";
                    $doc_log->ip = Yii::$app->request->userIP;
                    $doc_log->save();
                } else {
                    var_dump($model->errors);
                    die("Xato");
                }


                return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        $regions = Regions::find()->all();
        $branches = Branches::find()->all();

        return $this->render('create2', [
            'model' => $model,
            'regions' => $regions,
            'branches' => $branches,
        ]);
    }

    public function actionImport()
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

        return $this->render('import', ['model' => $model]);
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

    public function actionJoyidabartaraf()
    {
        echo "<pre>";
        $id = Yii::$app->request->post('Worklist')['id'];
        $file = UploadedFile::getInstanceByName('Worklist[file]');


        if ($file !== null) {
            $filename = $id . '.pdf';
            if ($file->saveAs('uploads/joyidabartaraf/' . $filename)) {
                $work = Work::findOne($id);
                $doc_log = new DocLog();
                $doc_log->work_id = $id;
                $doc_log->user_id = Yii::$app->user->id;
                $doc_log->status_old = $work->work_status;
                $doc_log->status_new = 3;
                $doc_log->action = "tekshiruv davomida bartaraf qilindi";
                $doc_log->ip = Yii::$app->request->userIP;

                $work->bartaraf_soni = $work->mistake_soni;
                $work->bartaraf_sum = $work->mistake_sum;

                if ($work->work_status === 0) {
                    $work->work_status = 3;
                    if ($work->save() && $doc_log->save())
                        return $this->redirect(['view', 'id' => $id]);
                }
            } else {
                echo "Failed to save file";
            }
        } else {
            echo "File not uploaded";
        }

        return $this->render('work/worklistview', [
            'model' => $model,
        ]);
    }

    public function actionQabul($work_id)
    {
        $model = $this->findModel($work_id);
        $work_status = $model->work_status;
        $model->work_status = '2';

        $worklist = Worklist::find()
            ->where(['work_id' => $work_id])
            ->orderBy(['id' => SORT_DESC]) // ketma-ketlik bo'yicha tartiblash
            ->one();
        $worklist->status = 2;

        $doc_log = new DocLog();
        $doc_log->work_id = $work_id;
        $doc_log->user_id = Yii::$app->user->id;
        $doc_log->status_old = $work_status;
        $doc_log->status_new = $model->work_status;
        $doc_log->action = "Qabul";
        $doc_log->ip = Yii::$app->request->userIP;

        if ($model->save() && $worklist->save() && $doc_log->save())
            return $this->redirect(['work/view', 'id'=>$work_id]);

        $model->work_status = $work_status;
        return $this->render('work/worklistview', [
            'model' => $model,
        ]);
    }

    public function actionRad($work_id)
    {
        $model = $this->findModel($work_id);
        $work_status = $model->work_status;
        $model->work_status = '2';

        $worklist = Worklist::find()
            ->where(['work_id' => $work_id])
            ->orderBy(['id' => SORT_DESC]) // ketma-ketlik bo'yicha tartiblash
            ->one();
        $worklist->status = 1;


        if ($model->save() && $worklist->save()) {

            $doc_log = new DocLog();
            $doc_log->work_id = $work_id;
            $doc_log->user_id = Yii::$app->user->id;
            $doc_log->status_old = $work_status;
            $doc_log->status_new = $model->work_status;
            $doc_log->action = "Rad";
            $doc_log->ip = Yii::$app->request->userIP;
            $doc_log->save();
//            return $this->redirect(['index']);
            return $this->redirect(['work/view', 'id' => $work_id]);
        }
        $model->work_status = $work_status;
        return $this->render('work/worklistview', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $regions = Regions::find()->all();

        return $this->render('update', [
            'model' => $model,
            'regions' => $regions
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $doc_log = new DocLog();
        $doc_log->work_id = $work_id;
        $doc_log->user_id = Yii::$app->user->id;
        $doc_log->status_old = $work_status;
        $doc_log->status_new = 0;
        $doc_log->action = "Delete";
        $doc_log->ip = Yii::$app->request->userIP;
        return $this->redirect(['index']);
    }

    public function actionDownload($id)
    {
        $path = Yii::getAlias('@frontend/web/uploads/depbartaraf/') . $id . '.pdf';

        if (file_exists($path)) {
            $response = Yii::$app->response;
            $doc_name = $id . "-sonli xizmat farmoyish.pdf";
            $response->sendFile($path, $doc_name, ['inline' => true]);
        } else {
            throw new \Exception('File not found');
        }
    }

    protected function findModel($id)
    {
        if (($model = Work::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findXabar($id)
    {
        if (($model = Xabar::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelworklist($work_id)
    {
        if (($model = Worklist::findOne(['work_id' => $work_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
