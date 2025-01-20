<?php

namespace frontend\controllers;

// controllers/ExportController.php

use app\models\Davomat;
use app\models\Export;
use kartik\grid\GridView;
use Yii;
use yii\web\Controller;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use yii\data\ActiveDataProvider;
use yii\web\Response;
use kartik\export\ExportMenu;

class ExportController extends Controller
{
    public function actionExport()
    {



        return $this->render('export', ['model' => $model]);
    }
}
