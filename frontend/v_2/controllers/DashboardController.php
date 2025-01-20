<?php

namespace frontend\controllers;

use app\models\AuthAssignment;
use app\models\data\Branches;
use app\models\search\WorkSearch;
use app\models\Work;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DashboardController extends Controller
{
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

    public function actionIndex()
    {
        $searchModel = new WorkSearch();
        $departamentsData = $searchModel->search2($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'departamentsData' => $departamentsData,
        ]);

    }
    public function actionAll()
    {
        return $this->render('all');
    }
    public function actionUzlashtirish()
    {
        $searchModel = new WorkSearch();
        $departamentsData = $searchModel->uzlashtirish($this->request->queryParams);

        return $this->render('uzlashtirish', [
            'searchModel' => $searchModel,
            'departamentsData' => $departamentsData,
        ]);
    }


    public function actionIndex2($year = "1", $region = '1', $farmoyish = '1')
    {
        $model = Work::find()->all();
        return $this->render('index2', [
            'model' => $model,
        ]);
    }
    public function actionDashboard($year = "1", $region = '1', $farmoyish = '1')
    {
        $model = Work::find()->all();
        return $this->render('dashboard', [
            'model' => $model,
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
        $model = new Branches();

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


    protected function findModel($id)
    {
        if (($model = Branches::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
