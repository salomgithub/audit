<?php

namespace frontend\controllers;

use app\models\data\Branches;
use app\models\data\BranchesSearch;
use app\models\data\HeadMistakesGroup;
use app\models\data\Mistakes;
use app\models\data\Orders;
use app\models\data\Regions;
use app\models\data\Status;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BranchesController implements the CRUD actions for Branches model.
 */
class MyController extends Controller
{
    public function actionListregions($id)
    {
        $region_id = Orders::findOne($id);
        $regions = Regions::find()->where(['id'=>$region_id->region_id])->all();
        $regionCounts = Regions::find()->where(['id'=>$region_id->region_id])->count();


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
//        $region_id = Orders::findOne($id);
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

    public function actionListheadmistakes($id)
    {
        $mistakes = Mistakes::find()->where(['head_mistakes_group_code'=>$id])->all();
        $mistakesCounts = Mistakes::find()->where(['head_mistakes_group_code'=>$id])->count();
        if ($mistakesCounts>0) {
            foreach ($mistakes as $misktake) {
                echo "<option value='".$misktake->code."'>".$misktake->name."</option>";
            }
        } else {
            echo "<option>-</option>";
        }
    }

    public function actionListmistakes($id)
    {
        $mistakes = Mistakes::findOne($id);
        $status = Status::findOne($mistakes->status);

        echo "<option value='".$status->id."'>".$status->name."</option>";

    }
    public function actionListqiymat($id)
    {
        $mistakes = Mistakes::findOne($id);

        echo $mistakes->quantity;

    }
    public function actionStatus($id)
    {
        $mistakes = Mistakes::findOne($id);
        $status = Status::findOne($mistakes->status);

        echo "<option value='".$status->id."'>".$status->name."</option>";

    }

    public function actionMistakes($id)
    {
        $mistakes = Mistakes::find()->all();
        $mistakesCounts = Mistakes::find()->count();

        if ($mistakesCounts>0) {
//            echo "<option value=''>.....</option>";
            foreach ($mistakes as $misktake) {
                echo "<option value='".$mistake->code."'>".$mistake->name."</option>";
            }
        } else {
            echo "<option>-</option>";
        }

    }
    protected function findModel($id)
    {
        if (($model = Branches::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
