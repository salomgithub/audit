<?php

namespace frontend\controllers;

use app\models\AuthAssignment;
use app\models\data\Branches;
use app\models\data\BranchesSearch;
use app\models\data\Departaments;
use app\models\data\Orders;
use app\models\data\OrdersSearch;
use app\models\data\Regions;
use app\models\search\WorkSearch;
use app\models\Work;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class AktController extends Controller
{
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
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAkt($code)
    {
        $data = Work::find()->where(['farmoyish_id' => $code])->all();
        $searchModel = new WorkSearch();
        $departamentsData = $searchModel->akt($this->request->queryParams);

        $branches = Work::find()
            ->select(['branch_id'])
            ->groupBy('branch_id')
            ->asArray()
            ->all();
        $branchesData = [];
        foreach ($branches as $branch) {
            $data = Work::find()->where(['farmoyish_id' => $code, 'branch_id' => $branch['branch_id']])->all();
            $soni = 0;
            $summasi = 0;
            $branchData = [
                'name' => Branches::findOne($branch['branch_id'])->name,
                'items' => []
            ];
            $mistakes = Work::find()
                ->select(['mistake_code', 'SUM(mistake_soni) AS total_mistake_soni', 'SUM(mistake_sum) AS total_mistake_sum'])
                ->groupBy(['mistake_code'])
                ->asArray()
                ->all();
//            echo "<pre>";
//var_dump($mistakes); die();
//            echo "$mistakes";

//                $branchData['mistake_code'] = $soni;
            $branchData['total_mistake_soni'] = $soni;
            $branchData['total_mistake_summasi'] = $summasi;
            $branchesData[] = $branchData;
        }
        return $this->render('akt', [
            'searchModel' => $searchModel,
            'branchesData' => $branchesData,
        ]);

    }

    public function actionView($id)
    {
        $branches = Work::find()
            ->select(['work.branch_id', 'branches.name'])
            ->join('JOIN', 'branches', 'work.branch_id = branches.id')
            ->groupBy('branch_id')
            ->where(['farmoyish_id' => $id])
            ->asArray()
            ->all();

        $branches = Work::find()
            ->select(['work.branch_id', 'branches.name'])
            ->join('JOIN', 'branches', 'work.branch_id = branches.id')
            ->groupBy('branch_id')
            ->orderBy('branch_id')
            ->where(['farmoyish_id' => $id])
            ->asArray()
            ->all();

        $salomlar = [];

        foreach ($branches as $branch) {
            $data = Work::find()
                ->where(['farmoyish_id' => $id, 'branch_id' => $branch['branch_id']])
                ->all();

            $branchData = [
                'name' => $branch['name'],
                'items' => []
            ];

            // Filial uchun bo'lgan head mistakes group code larini aniqlash
            $headMistakeGroupCodes = Work::find()
                ->select(['head_mistakes_group.name', 'head_mistakes_group_code'])
                ->join('JOIN', 'head_mistakes_group', 'head_mistakes_group.code = work.head_mistakes_group_code')
                ->where(['farmoyish_id' => $id, 'branch_id' => $branch['branch_id']])
                ->groupBy('head_mistakes_group_code')
                ->orderBy('head_mistakes_group_code')
                ->asArray()
                ->all();
            foreach ($headMistakeGroupCodes as $headMistakeGroupCode) {
                $items = [];
                $mistakesGroup = Work::find()
                    ->select(['mistake_code', 'mistakes.name', 'SUM(mistake_soni) as mistake_soni', 'SUM(mistake_sum) as mistake_sum'])
                    ->join('JOIN', 'mistakes', 'mistakes.code = work.mistake_code')
                    ->where(['farmoyish_id' => $id, 'branch_id' => $branch['branch_id'], 'work.head_mistakes_group_code' => $headMistakeGroupCode['head_mistakes_group_code']])
                    ->groupBy("mistake_code")
                    ->asArray()
                    ->all();

                $i = 0;
                foreach ($mistakesGroup as $mistake) {
                    $i++;

                    $items[$i] = [
                        'mistake_code' => $mistake['name'],
                        'mistake_soni' => $mistake['mistake_soni'],
                        'mistake_sum' => $mistake['mistake_sum'],
                        'clients' => [],
                    ];

                    $clients = Work::find()
                        ->select(['mistake_code', 'client_name', 'mistake_sum'])
                        ->where(['farmoyish_id' => $id, 'branch_id' => $branch['branch_id'], 'head_mistakes_group_code' => $headMistakeGroupCode, 'mistake_code' => $mistake['mistake_code']])
                        ->asArray()
                        ->all();
                    foreach ($clients as $client) {
                        $items[$i]['clients'][] = [
                            'client_name' => $client['client_name'],
                            'mistake_sum' => $client['mistake_sum'],
                        ];
                    }
                }

                $branchData['items'][] = [
                    'head_mistakes_group_code' => $headMistakeGroupCode,
//                    'head_mistakes_group_code_soni' => $head_mistakes_group_code_soni,
//                    'head_mistakes_group_code_summasi' => $head_mistakes_group_code_summasi,
                    'mistakes' => $items,
                ];
            }

            $salomlar[] = $branchData;
        }
        return $this->render('view', [
            'salomlar' => $salomlar,
        ]);
    }

    public function actionViewfilial($id)
    {
        $branches = Work::find()
            ->select(['work.branch_id', 'branches.name'])
            ->join('JOIN', 'branches', 'work.branch_id = branches.id')
            ->groupBy('branch_id')
            ->where(['farmoyish_id' => $id])
            ->asArray()
            ->all();

        return $this->render('view_filial', [
            'id' => $id,
            'branches' => $branches,
        ]);
    }

    public function actionViewfilialakt($id, $branch_id)
    {
        $branches = Work::find()
            ->select(['work.branch_id', 'branches.name'])
            ->join('JOIN', 'branches', 'work.branch_id = branches.id')
            ->groupBy('branch_id')
            ->where(['farmoyish_id' => $id])
            ->asArray()
            ->all();
        $salomlar = [];
        if (($id != '') && ($branch_id != '')) {
            $data = Work::find()
                ->where(['farmoyish_id' => $id, 'branch_id' => $branch_id])
                ->all();
            $branch_name = Branches::findOne($branch_id)->name;
            $region_name = Regions::findOne(Branches::findOne($branch_id)->region_id)->name;
            $branchData = [
                'name' => $branch_name,
                'items' => []
            ];

            // Filial uchun bo'lgan head mistakes group code larini aniqlash
            $headMistakeGroupCodes = Work::find()
                ->select(['head_mistakes_group.name', 'head_mistakes_group_code'])
                ->join('JOIN', 'head_mistakes_group', 'head_mistakes_group.code = work.head_mistakes_group_code')
                ->where(['farmoyish_id' => $id, 'branch_id' => $branch_id])
                ->groupBy('head_mistakes_group_code')
                ->orderBy('head_mistakes_group_code')
                ->asArray()
                ->all();
            foreach ($headMistakeGroupCodes as $headMistakeGroupCode) {
                $items = [];
                $mistakesGroup = Work::find()
                    ->select(['mistake_code', 'mistakes.name', 'SUM(mistake_soni) as mistake_soni', 'SUM(mistake_sum) as mistake_sum'])
                    ->join('JOIN', 'mistakes', 'mistakes.code = work.mistake_code')
                    ->where(['farmoyish_id' => $id, 'branch_id' => $branch_id, 'work.head_mistakes_group_code' => $headMistakeGroupCode['head_mistakes_group_code']])
                    ->groupBy("mistake_code")
                    ->asArray()
                    ->all();

                $i = 0;
                foreach ($mistakesGroup as $mistake) {
                    $i++;

                    $items[$i] = [
                        'mistake_code' => $mistake['name'],
                        'mistake_soni' => $mistake['mistake_soni'],
                        'mistake_sum' => $mistake['mistake_sum'],
                        'clients' => [],
                    ];

                    $clients = Work::find()
                        ->select(['mistake_code', 'client_name', 'mistake_sum'])
                        ->where(['farmoyish_id' => $id, 'branch_id' => $branch_id, 'head_mistakes_group_code' => $headMistakeGroupCode, 'mistake_code' => $mistake['mistake_code']])
                        ->asArray()
                        ->all();
                    foreach ($clients as $client) {
                        $items[$i]['clients'][] = [
                            'client_name' => $client['client_name'],
                            'mistake_sum' => $client['mistake_sum'],
                        ];
                    }
                }

                $branchData['items'][] = [
                    'head_mistakes_group_code' => $headMistakeGroupCode,
                    'mistakes' => $items,
                ];
            }

            $salomlar[] = $branchData;
        }
        return $this->render('view_filial', [
            'id' => $id,
            'region_name' => $region_name,
            'branches' => $branches,
            'salomlar' => $salomlar,
        ]);
    }

    public function actionViewfilial2($id)
    {
        $branches = Work::find()
            ->select(['work.branch_id', 'branches.name'])
            ->join('JOIN', 'branches', 'work.branch_id = branches.id')
            ->groupBy('branch_id')
            ->where(['farmoyish_id' => $id])
            ->asArray()
            ->all();

        $branches = Work::find()
            ->select(['work.branch_id', 'branches.name'])
            ->join('JOIN', 'branches', 'work.branch_id = branches.id')
            ->groupBy('branch_id')
            ->orderBy('branch_id')
            ->where(['farmoyish_id' => $id])
            ->asArray()
            ->all();

        $salomlar = [];

        foreach ($branches as $branch) {
            $data = Work::find()
                ->where(['farmoyish_id' => $id, 'branch_id' => $branch['branch_id']])
                ->all();

            $branchData = [
                'name' => $branch['name'],
                'items' => []
            ];

            // Filial uchun bo'lgan head mistakes group code larini aniqlash
            $headMistakeGroupCodes = Work::find()
                ->select(['head_mistakes_group.name', 'head_mistakes_group_code'])
                ->join('JOIN', 'head_mistakes_group', 'head_mistakes_group.code = work.head_mistakes_group_code')
                ->where(['farmoyish_id' => $id, 'branch_id' => $branch['branch_id']])
                ->groupBy('head_mistakes_group_code')
                ->orderBy('head_mistakes_group_code')
                ->asArray()
                ->all();
            foreach ($headMistakeGroupCodes as $headMistakeGroupCode) {
                $items = [];
                $mistakesGroup = Work::find()
                    ->select(['mistake_code', 'mistakes.name', 'SUM(mistake_soni) as mistake_soni', 'SUM(mistake_sum) as mistake_sum'])
                    ->join('JOIN', 'mistakes', 'mistakes.code = work.mistake_code')
                    ->where(['farmoyish_id' => $id, 'branch_id' => $branch['branch_id'], 'work.head_mistakes_group_code' => $headMistakeGroupCode['head_mistakes_group_code']])
                    ->groupBy("mistake_code")
                    ->asArray()
                    ->all();

                $i = 0;
                foreach ($mistakesGroup as $mistake) {
                    $i++;

                    $items[$i] = [
                        'mistake_code' => $mistake['name'],
                        'mistake_soni' => $mistake['mistake_soni'],
                        'mistake_sum' => $mistake['mistake_sum'],
                        'clients' => [],
                    ];

                    $clients = Work::find()
                        ->select(['mistake_code', 'client_name', 'mistake_sum'])
                        ->where(['farmoyish_id' => $id, 'branch_id' => $branch['branch_id'], 'head_mistakes_group_code' => $headMistakeGroupCode, 'mistake_code' => $mistake['mistake_code']])
                        ->asArray()
                        ->all();
                    foreach ($clients as $client) {
                        $items[$i]['clients'][] = [
                            'client_name' => $client['client_name'],
                            'mistake_sum' => $client['mistake_sum'],
                        ];
                    }
                }

                $branchData['items'][] = [
                    'head_mistakes_group_code' => $headMistakeGroupCode,
                    'mistakes' => $items,
                ];
            }

            $salomlar[] = $branchData;
        }
        return $this->render('view_filial', [
            'salomlar' => $salomlar,
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

    public function actionDownload($id)
    {
        $path = Yii::getAlias('@frontend/web/uploads/farmoyish/') . $id . '.pdf';

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
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
