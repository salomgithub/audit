<?php

namespace frontend\controllers;

use app\models\AuthAssignment;
use app\models\data\Branches;
use app\models\data\BranchesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * BranchesController implements the CRUD actions for Branches model.
 */
class BranchesController extends Controller
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

    public function actionIndex()
    {
        $searchModel = new BranchesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionMail()
    {
        $result = Yii::$app->mailer->compose()
            ->setFrom('test@ingo.uz')
            ->setTo('s.yuldashev@ingo.uz')
            ->setSubject('ok subject')
            ->setTextBody('ok text body')
            ->setHtmlBody('ok HTML')
            ->send();
        var_dump($result);
        die();
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
