<?php

namespace frontend\controllers;

use app\models\AuthAssignment;
use app\models\data\Branches;
use app\models\data\Regions;
use app\models\DocLog;
use app\models\Work;
use app\models\search\WorkSearch;
use app\models\Xabar;
use frontend\models\Worklist;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
                ->orderBy(['id' => SORT_DESC]) // San'atlarni ketma-ketlik bo'yicha tartiblash
                ->one();
            $worklist->status = 4;

            if ($model->save() && $worklist->save()){
                $doc_log = new DocLog();
                $doc_log->work_id = $work_id;
                $doc_log->user_id = Yii::$app->user->id;
                $doc_log->status_old = $work_status;
                $doc_log->status_new = $model->work_status;
                $doc_log->action = "Rad";
                $doc_log->ip = Yii::$app->request->userIP;
                $doc_log->save();
                return $this->redirect(['index']);
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
                $soni = $model->mistake_sum;
                $model->mistake_sum = str_replace(" ", "", $soni);
                if($model->unical ==='')$model->unical = 0;
                if($model->hisob_raqam ==='')$model->hisob_raqam = 0;
                if ($model->bartaraf_soni > 0 && $model->bartaraf_sum > 0) {
                    $model->work_status = 3;

                    $new = new Work();
                    $new->farmoyish_id = $model->farmoyish_id;
                    $new->region_id = $model->region_id;
                    $new->branch_id = $model->branch_id;
                    $new->year = $model->year;

                    $new->unical = $model->unical;
                    $new->hisob_raqam = $model->hisob_raqam;

                    $new->client_name = $model->client_name;
                    $new->head_mistakes_group_code = $model->head_mistakes_group_code;
                    $new->mistake_code = $model->mistake_code;
                    $new->status = $model->status;
                    $new->mistake_soni = $model->mistake_soni - $model->bartaraf_soni;
                    $new->mistake_sum = ($model->mistake_sum ?? 0) - $model->bartaraf_sum;
                    $new->mistak_from_user = $model->mistak_from_user;
                    $new->user_id = $model->user_id;
                    $new->departament_id = $model->departament_id;
                    $new->comment = $model->comment;
                    $new->work_status = 0;

                    $model->unical = $model->unical??0;
                    $model->mistake_sum = $model->mistake_sum ?? 0;
                    $model->mistake_soni = $model->bartaraf_soni;
                    $model->mistake_sum = $model->bartaraf_sum;
                }
                if ($model->save()) {
                    if ($model->work_status == 3) {
                        $a = $new->save(false);
                    }
                    return $this->redirect(['index']);
                }
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

    public function actionQabul($work_id)
    {
        $model = $this->findModel($work_id);
        $work_status = $model->work_status;
        $model->work_status = '2';

        $worklist = Worklist::find()
            ->where(['work_id' => $work_id])
            ->orderBy(['id' => SORT_DESC]) // San'atlarni ketma-ketlik bo'yicha tartiblash
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
            return $this->redirect(['index']);

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
            ->orderBy(['id' => SORT_DESC]) // San'atlarni ketma-ketlik bo'yicha tartiblash
            ->one();
        $worklist->status = 1;


        if ($model->save() && $worklist->save()){

            $doc_log = new DocLog();
            $doc_log->work_id = $work_id;
            $doc_log->user_id = Yii::$app->user->id;
            $doc_log->status_old = $work_status;
            $doc_log->status_new = $model->work_status;
            $doc_log->action = "Rad";
            $doc_log->ip = Yii::$app->request->userIP;
            $doc_log->save();
            return $this->redirect(['index']);
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

        return $this->render('update', [
            'model' => $model,
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
