<?php

namespace frontend\controllers;

use app\models\AuthAssignment;
use app\models\data\Departaments;
use app\models\data\Regions;
use app\models\DocLog;
use app\models\search\WorklistSearch;

use app\models\Work;
use app\models\Xabar;
use frontend\models\Worklist;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\User;

/**
 * WorklistController implements the CRUD actions for Worklist model.
 */
class WorklistController extends MyController
{

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        if (!Yii::$app->user->isGuest) {
            $user_id = Yii::$app->user->id;
            $role = AuthAssignment::findOne(['user_id' => $user_id]);
            $role = $role->item_name?$role->item_name:0;
            if ($role === 'Administrator') {
                $this->layout= 'main';
            }
            if ($role === 'admin_audit') {
                $this->layout= 'main';
            }
            if ($role === 'auditor') {
                $this->layout= 'auditors';
            }
            if ($role === 'departaments') {
                $this->layout= 'departaments';
            }
            if ($role === 'monitoring') {
                $this->layout= 'main';
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
     * Lists all Worklist models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user_id = Yii::$app->user->id;
        $dep_id = \common\models\User::findOne($user_id)->dep_id;
        $role = AuthAssignment::findOne(['user_id' => $user_id]);
        $role = $role->item_name;
        if ($role === 'Administrator') {
            $searchModel = new WorklistSearch();
            $dataProvider = $searchModel->search($this->request->queryParams);
        }
        $searchModel = new WorklistSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMylist()
    {
        $user_id = Yii::$app->user->id;
        $dep_id = \common\models\User::findOne($user_id)->dep_id;
        $list = Worklist::find()->where(['dep_id' => $dep_id])->all();
        $dep_name = Departaments::findOne($dep_id)->name;
        return $this->render('mylist', [
            'list' => $list,
            'dep_name' => $dep_name,
        ]);
    }

    public function actionList()
    {
        $user_id = Yii::$app->user->id;
        $dep_id = \common\models\User::findOne($user_id)->dep_id;
        $list = Work::find()->where(['departament_id' => $dep_id])
            ->andWhere(['IN', 'work_status', [0, 2]])
            ->all();
        $dep_name = Departaments::findOne($dep_id)->name;


        return $this->render('list', [
            'list' => $list,
            'dep_name' => $dep_name,
        ]);
    }

    public function actionEdit($id)
    {

        $model = Worklist::findOne(['work_id'=>$id]);

        $work = Work::findOne($id);
        $status_old = $work->work_status;
        $work->work_status = 1;
        $user_id = Yii::$app->user->id;

        $doc_log = new DocLog();
        $doc_log->work_id = $id;
        $doc_log->user_id = $user_id;
        $doc_log->status_old = $status_old;
        $doc_log->status_new = $status_old;
        $doc_log->action = "document ochildi";
        $doc_log->ip = Yii::$app->request->userIP;
        $doc_log->save();

        if (!isset($model->work_id))
            $model = new Worklist();

        if ($this->request->isPost) {

            $dep_id = \common\models\User::findOne($user_id)->dep_id;
            $model->dep_id = $dep_id;
//            $model->mistake_name = ??

            if ($model->upload($id)) {
                $fileExtension = pathinfo($model->file, PATHINFO_EXTENSION); // Faylning uzantisi
                $file = $id . '.' . $fileExtension;
//               $model->save();

            }

            if ($model->load($this->request->post())) {
                $model->file = $file;
                $model->status = 1;
                $work = Work::findOne($id);
                $status_old = $work->work_status;
                $work->work_status = 1;

                $doc_log = new DocLog();
                $doc_log->work_id = $id;
                $doc_log->user_id = $user_id;
                $doc_log->status_old = $status_old;
                $doc_log->status_new = $work->work_status;
                $doc_log->action = "Tasdiqlash uchun yuborildi";
                $doc_log->ip = Yii::$app->request->userIP;

                if ($model->save() && $work->save() && $doc_log->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }

        } else {
            $model->loadDefaultValues();
        }

        $xabar = Xabar::find()
            ->where(['work_id' => $id])
            ->orderBy(['id' => SORT_DESC]) // San'atlarni ketma-ketlik bo'yicha tartiblash
            ->one();

        return $this->render('edit', [
            'model' => $model,
            'id' => $id,
            'xabar' => $xabar,
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
        $model = new Worklist();
        $user_id = Yii::$app->user->id;

        $work = Work::find()->all();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'work' => $work,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $work = Work::find()->all();
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'work' => $work,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDownload($id) {
        $path = Yii::getAlias('@frontend/web/uploads/depbartaraf/') . $id . '.pdf';

        if (file_exists($path)) {
            $response = Yii::$app->response;
            $doc_name = $id."-sonli xizmat farmoyish.pdf";
            $response->sendFile($path, $doc_name, ['inline' => true]);
        } else {
            throw new \Exception('File not found');
        }
    }

    protected function findModel($id)
    {
        if (($model = Worklist::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModellist($id)
    {
        if (($model = Work::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
