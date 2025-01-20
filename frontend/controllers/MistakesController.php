<?php

namespace frontend\controllers;

use app\models\AuthAssignment;
use app\models\data\Mistakes;
use app\models\data\MistakesSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MistakesController implements the CRUD actions for Mistakes model.
 */
class MistakesController extends Controller
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

    public function actionIndex()
    {
        $searchModel = new MistakesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($code)
    {
        return $this->render('view', [
            'model' => $this->findModel($code),
        ]);
    }

    public function actionCreate()
    {
        $model = new Mistakes();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'code' => $model->code]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($code)
    {
        $model = $this->findModel($code);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'code' => $model->code]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($code)
    {
        $this->findModel($code)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($code)
    {
        if (($model = Mistakes::findOne(['code' => $code])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
