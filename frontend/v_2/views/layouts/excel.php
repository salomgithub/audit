<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\ButtonDropdown;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

// Menu elementlari ro'yxati

$menuItems = [
    [
        'label' => '<i class="menu-icon tf-icons bx bx-receipt"></i> Umumiy',
        'url' => ['/dashboard/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'dashboard', // Bu qatorni qo'shing
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-task"></i> Natijalar',
        'url' => ['/work/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'work', // Bu qatorni qo'shing
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-dock-top"></i> Bartaraf qilish',
        'url' => ['/worklist/list'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'worklist' && Yii::$app->controller->action->id == 'list', // Bu qatorni qo'shing
    ],
    [
        'label' => '<i class="mmenu-icon tf-icons bx bx-layer"></i> Bartaraf qilinganlar tarixi',
        'url' => ['/worklist/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'worklist' && Yii::$app->controller->action->id == 'index', // Bu qatorni qo'shing
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-check"></i> Farmoyishlar',
        'url' => ['/orders/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'orders', // Bu qatorni qo'shing
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-cube"></i> Kamchiliklar',
        'url' => ['/mistakes/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'mistakes', // Bu qatorni qo'shing
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-collection"></i> Departament',
        'url' => ['/departaments/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'departaments', // Bu qatorni qo'shing
    ],
    // Boshqa menularni ham qo'shing va ularga mos holatni qo'shing
];
$menuHelp = [
    [
        'label' => '<i class="menu-icon tf-icons bx bx-error-alt"></i> Kamchiliklar',
        'url' => ['/mistakes/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'dashboard', // Bu qatorni qo'shing
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-layout"></i> Departamentlar',
        'url' => ['/departaments/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'work', // Bu qatorni qo'shing
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-lock"></i> Foydalanuvchilar',
        'url' => ['/admin/user'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'worklist' && Yii::$app->controller->action->id == 'list', // Bu qatorni qo'shing
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-dock-top"></i> Filiallar',
        'url' => ['/branches/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'worklist' && Yii::$app->controller->action->id == 'index', // Bu qatorni qo'shing
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-box"></i> Farmoyishlar',
        'url' => ['/orders/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'orders', // Bu qatorni qo'shing
    ],

    // Boshqa menularni ham qo'shing va ularga mos holatni qo'shing
];
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="d-flex flex-column h-100" >
    <?php $this->beginBody() ?>



    <div class="">
        <header>
            <?php
            NavBar::begin([
                'brandLabel' => Html::img('/img/xb-gold.png', ['alt' => 'Logo', 'width' => '155', 'height' => '35']),
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar navbar-expand-md navbar-dark bg-dark ',
                ],
            ]);
            ?>

            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-9 text-end">
                        <?php
                        if (!Yii::$app->user->isGuest) {
                            echo ButtonDropdown::widget([
                                'label' => 'Yordamchi stol',
                                'options' => ['class' => 'btn btn-secondary'],
                                'dropdown' => [
                                    'items' => $menuHelp,
                                ],
                            ]);
                        }
                        ?>
                    </div>

                    <div class="col-md-3 text-end">
                        <?php
                        if (Yii::$app->user->isGuest) {
                            echo Html::tag('div',Html::a('Login',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
                        } else {
                            echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
                                . Html::submitButton(
                                    'Logout (' . Yii::$app->user->identity->username . ')',
                                    ['class' => 'btn btn-link logout text-decoration-none']
                                )
                                . Html::endForm();
                        }
                        ?>
                    </div>
                </div>
            </div>

            <?php
            NavBar::end();
            ?>

        </header>
        <div class="row">
            <aside class="col-md-2 " style="box-shadow: 0 0 15px rgba(0, 0, 0, 0.9);">
                <nav>
                    <ul class="nav flex-column">
                        <?php foreach ($menuItems as $item): ?>
                            <li class="nav-item" >
                                <?= Html::a($item['label'], $item['url'], ['class' => 'nav-link']) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </aside>
            <main role="main" class="col-md-10">
                <div class="">
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </main>
        </div>
    </div>



    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
