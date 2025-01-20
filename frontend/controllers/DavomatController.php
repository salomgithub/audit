<?php

namespace frontend\controllers;

use app\models\AuthAssignment;
use app\models\Davomat;
use app\models\DavomatSearch;
use app\models\Export;
use common\models\User;
use DateInterval;
use DatePeriod;
use DateTime;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DavomatController implements the CRUD actions for Davomat model.
 */
class DavomatController extends Controller
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
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Davomat models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DavomatSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $model = new Export(); // ExportForm modelini yaratamiz

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Foydalanuvchi vaqt oraligini olish
            $data_start = $model->data_start . " 00:00:01";
            $data_end = $model->data_end . " 23:59:59";

            $start_date = new DateTime($data_start);
            $end_date = new DateTime($data_end);
            $interval = new DateInterval('P1D'); // 1 kunlik interval
            $period = new DatePeriod($start_date, $interval, $end_date);
            $users = User::find()
                ->select(['id', 'fio'])
                ->all();
            $data = [];
            foreach ($period as $one_day) {
                $data_start = $one_day->format('Y-m-d') . " 00:00:01";
                $data_end = $one_day->format('Y-m-d') . " 23:59:59";
                $data[] = [
                    'user_name' => "-------------",
                    'in' => "-----------------",
                    'out' => "-----------------",
                    'data' => $one_day->format('Y-m-d'),
                ];
                foreach ($users as $user) {
                    $in = Davomat::find()
                        ->select(['employee_id', 'MIN(time) as time'])
                        ->where(['between', 'time', $data_start, $data_end])
                        ->andWhere(['employee_id' => $user->id, 'action' => 1])
                        ->groupBy(['employee_id'])
                        ->one();

                    $out = Davomat::find()
                        ->select(['employee_id', 'MAX(time) as time'])
                        ->where(['between', 'time', $data_start, $data_end])
                        ->andWhere(['employee_id' => $user->id, 'action' => 2])
                        ->groupBy(['employee_id'])
                        ->one();

                    if (!empty($in) || !empty($out)) {
                        $data[] = [
                            'user_name' => $user->fio,
                            'in' => ($in->time ?? 0),
                            'out' => ($out->time ?? 0),
                            'data' => '',
                        ];
                    } else {
                        $data[] = [
                            'user_name' => $user->fio,
                            'in' => "-",
                            'out' => "-",
                            'data' => "",
                        ];
                    }
                }


            }

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Ustunlarni yozish
            $sheet->setCellValue('B1', 'Oraliq vaqt');
            $sheet->setCellValue('C1', "$model->data_start.'-dan '");
            $sheet->setCellValue('D1', "$model->data_end.'-gacha '");

            $sheet->setCellValue('A3', 'Kun');
            $sheet->setCellValue('B3', 'FIO');
            $sheet->setCellValue('C3', 'ishga kelgan vaqti');
            $sheet->setCellValue('D3', 'Ishdan chiqgan vaqti');
            // Ma'lumotlarni yozish
            $rowIndex = 4;
            foreach ($data as $row) {
                $sheet->setCellValue('A' . $rowIndex, $row['data']);
                $sheet->setCellValue('B' . $rowIndex, $row['user_name']);
                $sheet->setCellValue('C' . $rowIndex, $row['in']);
                $sheet->setCellValue('D' . $rowIndex, $row['out']);
                $rowIndex++;
            }

            // Excel faylini saqlash uchun nom yaratish
            $filename = 'export_' . date('Y-m-d') . '.xlsx';

            // Excel faylini yaratgan faylga saqlash
            $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save($filename);

            // Faylni foydalanuvchiga yuborish
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            readfile($filename);
            unlink($filename); // Faylni o'chirish
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionAuditor()
    {
        $searchModel = new DavomatSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);


        return $this->render('auditor', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
//            'model' => $model,
        ]);
    }


    public function actionIndex2()
    {
        $model = new Export(); // ExportForm modelini yaratamiz
        $start = date("Y-m-d") . " 00:00:01";
        $end = date("Y-m-d") . " 23:59:59";
        $users = User::find()
            ->select(['id', 'fio'])
            ->all();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Foydalanuvchi vaqt oraligini olish
            $data_start = $model->data_start . " 00:00:01";
            $data_end = $model->data_end . " 23:59:59";
            $start_date = new DateTime($data_start);
            $end_date = new DateTime($data_end);
            $interval = new DateInterval('P1D'); // 1 kunlik interval
            $period = new DatePeriod($start_date, $interval, $end_date);

            $data = [];
            foreach ($period as $one_day) {
                $data_start = $one_day->format('Y-m-d') . " 00:00:01";
                $data_end = $one_day->format('Y-m-d') . " 23:59:59";
                $data[] = [
                    'data' => $one_day->format('Y-m-d'),
                    'user_name' => "-------------",
                    'in' => "-----------------",
                    'out' => "-----------------",
                ];
                foreach ($users as $user) {
                    $in = Davomat::find()
                        ->select(['employee_id', 'MIN(time) as time'])
                        ->where(['between', 'time', $data_start, $data_end])
                        ->andWhere([ 'action' => 1])
                        ->andWhere([ 'employee_id' => $user->id])
                        ->groupBy(['employee_id'])
                        ->one();

                    $out = Davomat::find()
                        ->select(['employee_id', 'MAX(time) as time'])
                        ->where(['between', 'time', $data_start, $data_end])
                        ->andWhere([ 'action' => 2])
                        ->andWhere([ 'employee_id' => $user->id])
                        ->groupBy(['employee_id'])
                        ->one();

                    if (!empty($in) || !empty($out)) {
                        $data[] = [
                            'data' => $one_day->format('Y-m-d'),
                            'user_name' => $user->fio,
                            'in' => ($in->time ?? 0),
                            'out' => ($out->time ?? 0),
                        ];

                    } else {
                        $data[] = [
                            'data' => $one_day->format('Y-m-d'),
                            'user_name' => $user->fio,
                            'in' => "-",
                            'out' => "-",
                        ];
                    }
                }
            }
        } else {
            $data[] = [
                'data' => date("Y-m-d"),
                'user_name' => "-------------",
                'in' => "-----------------",
                'out' => "-----------------",
            ];
            foreach ($users as $user) {

                $in = Davomat::find()
                    ->select(['employee_id', 'MIN(time) as time'])
                    ->where(['between', 'time', $start, $end])
                    ->andWhere(['action' => 1])
                    ->andWhere([ 'employee_id' => $user->id])
                    ->groupBy(['employee_id'])
                    ->one();

                $out = Davomat::find()
                    ->select(['employee_id', 'MAX(time) as time'])
                    ->where(['between', 'time', $start, $end])
                    ->andWhere(['employee_id'=>$user->id, 'action' => 2])
                    ->groupBy(['employee_id'])
                    ->one();

                if (!empty($in) || !empty($out)) {
                    $data[] = [
                        'user_name' => $user->fio,
                        'in' => ($in->time ?? 0),
                        'out' => ($out->time ?? 0),
                        'data' => '0',
                    ];
                } else {
                    $data[] = [
                        'user_name' => $user->fio,
                        'in' => "-",
                        'out' => "-",
                        'data' => "",
                    ];
                }
            }
        }

        return $this->render('index2', [
            'model' => $model,
            'data' => $data,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Davomat();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSaveimagein()
    {
        $imageData = Yii::$app->request->post('image');
        $filename = Yii::$app->request->post('filename');
        $uploadPath = 'uploads/' . $filename;

        // Rasmni serverga saqlash
        $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));

        if (empty($decodedImage)) {
            // Rasmni tuzatishda xatolik yuz berdi
            Yii::$app->response->setStatusCode(500); // Internal Server Error

            return 'Xatolik rasmni saqlashda yuz berdi.';

        }

        if (file_put_contents($uploadPath, $decodedImage) !== false) {
            // Rasm saqlandi
            $user_id = Yii::$app->user->id;
            $model = new Davomat();
            $model->employee_id = $user_id;
            $model->action = 1;
            $model->photo = '/' . $uploadPath;
            if ($model->save()) {
                return 'Rasm saqlandi--++------: ' . $uploadPath;
            } else return "NO";
        } else {
            // Xatolikni qaytarish
            Yii::$app->response->setStatusCode(500); // Internal Server Error
            return 'Xatolik rasmni saqlashda yuz berdi.';
        }
    }

    public function actionSaveimageout()
    {
        $imageData = Yii::$app->request->post('image');
        $filename = Yii::$app->request->post('filename');
        $uploadPath = 'uploads/' . $filename;

        // Rasmni serverga saqlash
        $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));

        if (empty($decodedImage)) {
            // Rasmni tuzatishda xatolik yuz berdi
            Yii::$app->response->setStatusCode(500); // Internal Server Error

            return 'Xatolik rasmni saqlashda yuz berdi.';

        }

        if (file_put_contents($uploadPath, $decodedImage) !== false) {
            // Rasm saqlandi
            $user_id = Yii::$app->user->id;
            $model = new Davomat();
            $model->employee_id = $user_id;
            $model->action = 2;
            $model->photo = '/' . $uploadPath;
            if ($model->save()) {
                return 'Rasm saqlandi--++-: ' . $uploadPath;
            } else return "NO";
        } else {
            // Xatolikni qaytarish
            Yii::$app->response->setStatusCode(500); // Internal Server Error
            return 'Xatolik rasmni saqlashda yuz berdi.';
        }
    }


    protected function findModel($id)
    {
        if (($model = Davomat::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
