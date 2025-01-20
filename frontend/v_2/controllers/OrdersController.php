<?php

namespace frontend\controllers;

use app\models\AuthAssignment;
use app\models\data\Branches;
use app\models\data\Orders;
use app\models\data\OrdersSearch;
use app\models\data\Regions;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends Controller
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
        $searchModel = new OrdersSearch();
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
        $model = new Orders();

        if ($this->request->isPost) {
//            $user = Yii::$app->user->id;
//            if ($user < 0) die();

            if ($model->load($this->request->post()) && $model->save()) {
                $id = $model->code;
                if ($model->upload($id)) {
                    $fileExtension = pathinfo($model->file, PATHINFO_EXTENSION); // Faylning uzantisi
                    $model->file = $id . '.' . $fileExtension;
//                    $model->user_id = Yii::$app->user->id;
                    $model->save();
                }
                return $this->redirect(['view',
                    'code' => $model->code,
                    'region_id' => $model->region_id,
                ]);
            }
        } else {
            $model->loadDefaultValues();
        }
        $regions = Regions::find()->all();
        $branches = Branches::find()->all();
        return $this->render('create', [
            'model' => $model,
            'branches' => $branches,
            'regions' => $regions,
        ]);
    }

    public function actionUpdate($code)
    {
        $model = $this->findModel($code);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $id = $model->code;
            if ($model->upload($id)) {
                $fileExtension = pathinfo($model->file, PATHINFO_EXTENSION); // Faylning uzantisi
                $model->file = $id . '.' . $fileExtension;
//                    $model->user_id = Yii::$app->user->id;
                $model->save();
            }
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

    public function actionListregions($id)
    {
        $region_id = Orders::findOne($id);
        $regions = Regions::find()->where(['region_id'=>$region_id->region_id])->all();
        $regionCounts = Branches::find()->where(['region_id'=>$id])->count();


        if ($regionCounts>0) {
//            echo "<option value=''>.....</option>";
            foreach ($regions as $region) {
                echo "<option value='".$region->id."'>".$region->name."</option>";
            }
        } else {
            echo "<option>-</option>";
        }

    }

    public function actionListbranches($id)
    {
        $branches = Branches::find()->where(['region_id'=>$id])->all();
        $branchesCounts = Branches::find()->where(['region_id'=>$id])->count();


        if ($branchesCounts>0) {
//            echo "<option value=''>.....</option>";
            foreach ($branches as $branch) {
                echo "<option value='".$branch->id."'>".$branch->name."</option>";
            }
        } else {
            echo "<option>-</option>";
        }

    }


    public function actionDownload($id) {
        $path = Yii::getAlias('@frontend/web/uploads/farmoyish/') . $id . '.pdf';

        if (file_exists($path)) {
            $response = Yii::$app->response;
            $doc_name = $id."-sonli xizmat farmoyish.pdf";
            $response->sendFile($path, $doc_name, ['inline' => true]);
        } else {
            throw new \Exception('File not found');
        }
    }

    protected function findModel($code)
    {
        if (($model = Orders::findOne(['code' => $code])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
