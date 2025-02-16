<?php

/** @var \yii\web\View $this */

/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset4;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\ButtonDropdown;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset4::register($this);

// Menu elementlari ro'yxati

$tekshiruv = [
    [
        'label' => '<i class="menu-icon tf-icons bx "></i> Натижалар',
        'url' => ['/work/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'work',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx"></i> Камчилик киритиш',
        'url' => ['/work/create'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'work',
    ],
//    [
//        'label' => '<i class="menu-icon tf-icons bx bx-task"></i> Жойида бартараф',
//        'url' => ['/work/create2'],
//        'encode' => false,
//        'active' => Yii::$app->controller->id == 'work',
//    ],
    [
        'label' => '<i class="menu-icon tf-icons bx "></i> Бартараф қилиш',
        'url' => ['/worklist/list'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'worklist' && Yii::$app->controller->action->id == 'list',
    ],
    [
        'label' => '<i class="mmenu-icon tf-icons bx "></i> Бартараф қилинганлар тарихи',
        'url' => ['/worklist/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'worklist' && Yii::$app->controller->action->id == 'index',
    ],
];
$hisobot = [
    [
        'label' => '<i class="menu-icon tf-icons bx bx-box"></i> Фармойишлар',
        'url' => ['/orders/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'orders',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-receipt"></i> Умумий таҳлил',
        'url' => ['/dashboard/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'dashboard',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-receipt"></i> Ўзлаштиришлар таҳлили',
        'url' => ['/dashboard/uzlashtirish'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'dashboard',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-receipt"></i> AKT',
        'url' => ['/akt/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'akt',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-lock"></i> Кунлик бажарилган ишлар',
        'url' => ['/kunlik/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'worklist' && Yii::$app->controller->action->id == 'list',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-error-alt"></i> Давомат кунма-кун',
        'url' => ['/davomat/index2'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'davomat',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-error-alt"></i> Давомат детализация',
        'url' => ['/davomat/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'davomat',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-error-alt"></i> KPI',
        'url' => ['/kpi/kpi'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'kpi',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-error-alt"></i> Aktivlar',
        'url' => ['/finance/aktivlar'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'finance',
    ],


    // Boshqa menularni ham qo'shing va ularga mos holatni qo'shing
];
$users = [
    [
        'label' => '<i class="menu-icon tf-icons bx bx-layout"></i> Департаментлар',
        'url' => ['/departaments/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'work',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-dock-top"></i> Филиаллар',
        'url' => ['/branches/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'worklist' && Yii::$app->controller->action->id == 'index',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-error-alt"></i> Камчиликлар',
        'url' => ['/mistakes/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'dashboard',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-layout"></i> Логлар',
        'url' => ['/doc-log/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'doc-log',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-layout"></i> Департаментлар',
        'url' => ['/departaments/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'work',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-lock"></i> Фойдаланувчилар',
        'url' => ['/admin/user'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'worklist' && Yii::$app->controller->action->id == 'list',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-lock"></i> Логин & Парол',
        'url' => ['/site/users_list'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'site' && Yii::$app->controller->action->id == 'users_list',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-lock"></i> Фойдаланувчи қўшиш',
        'url' => ['/admin/user/signup'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'worklist' && Yii::$app->controller->action->id == 'list',
    ],

    // Boshqa menularni ham qo'shing va ularga mos holatni qo'shing
];
$sozlamalar = [
    [
        'label' => '<i class="menu-icon tf-icons bx bx-task"></i> Kamchilik kiritish',
        'url' => ['/work/create'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'work',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-task"></i>Tekshiruv davomida bartaraf qilingan kamchiliklarni kiritish',
        'url' => ['/work/create2'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'work',
    ],

    // Boshqa menularni ham qo'shing va ularga mos holatni qo'shing
];
$moliyaviy_tahlil = [
    [
        'label' => '<i class="menu-icon tf-icons bx bx-task"></i> Aктивлар таҳлили',
        'url' => ['/finance/aktivlar'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'finance',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-task"></i>Мажбурият таҳлили',
        'url' => ['/finance/majburiyatlar'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'finance',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-task"></i>Капитал',
        'url' => ['/finance/kapital'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'finance',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-task"></i>Смета',
        'url' => ['/finance/smeta'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'finance',
    ],
    [
        'label' => '<i class="menu-icon tf-icons bx bx-task"></i>Баланс',
        'url' => ['/balance/index'],
        'encode' => false,
        'active' => Yii::$app->controller->id == 'balance',
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
    <body  class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <?php $currentPage = basename($_SERVER['SCRIPT_NAME']); ?>
        <?php
        // Sidebar-Menu structure -->
        $menuItems = [
            [
                "menuTitle" => "Menu",
                "icon" => "fas fa-home",
                "pages" => [
                    [
                        "title" => "Home",
                        "url" => "index.php",
                    ],
                    [
                        "title" => "Alerts",
                        "url" => "alerts.php",
                    ],
                ],
            ],
            // [
            //     "menuTitle" => "Settings",
            //     "icon" => "fas fa-cogs",
            //     "pages" => [
            //         [
            //             "title" => "Profile",
            //             "url" => "profile.php",
            //         ],
            //     ],
            // ]
        ];
        ?>

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left side of the navbar -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="./" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Search form -->
            <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search"
                           name="search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Right side of the navbar -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#messages">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">2</span>
                    </a>
                </li>
                <!-- Notifications dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#notifications">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">5</span>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Logo -->
            <a href="./" class="brand-link">
                <img src="/img/xb-gold.png" alt="" class="brand-image  "
                     style="opacity: .6">
                <span class="brand-text font-weight-light">Admin</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/img/default.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="./" class="d-block">FIO</a>
                    </div>
                </div>
<h1><?= $currentPage ?></h1>
                <!-- Sidebar menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <?php foreach ($menuItems as $menuItem): ?>
                            <?php
                            $isActive = false;
                            $isMenuOpen = false;
                            foreach ($menuItem['pages'] as $page) {
                                if ($currentPage === $page['url']) {
                                    $isActive = true;
                                    $isMenuOpen = true;
                                    break;
                                }
                            }
                            ?>
                            <li class="nav-item has-treeview <?= $isMenuOpen ? 'menu-open' : '' ?>">
                                <a class="nav-link <?= $isActive ? 'active' : '' ?>">
                                    <i class="nav-icon <?= $menuItem['icon'] ?>"></i>
                                    <p>
                                        <?= $menuItem['menuTitle'] ?>
                                        <?php if (!empty($menuItem['pages'])): ?>
                                            <i class="right fas fa-angle-left"></i>
                                        <?php endif; ?>
                                    </p>
                                </a>
                                <?php if (!empty($menuItem['pages'])): ?>
                                    <ul class="nav nav-treeview">
                                        <?php foreach ($menuItem['pages'] as $page): ?>
                                            <li class="nav-item">
                                                <a href="<?= $page['url'] ?>"
                                                   class="nav-link <?= $currentPage === $page['url'] ? 'active' : '' ?>">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p><?= $page['title'] ?></p>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <?php
        function renderHeader($pageTitle, $breadcrumbItems)
        {
            ?>
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">
                                <?= $pageTitle; ?>
                            </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?php foreach ($breadcrumbItems as $item): ?>
                                    <?php if ($item['url'] === '#'): ?>
                                        <li class="breadcrumb-item active"><?= $item['title']; ?></li>
                                    <?php else: ?>
                                        <li class="breadcrumb-item"><a href="<?= $item['url']; ?>"><?= $item['title']; ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>


        <div class="content-wrapper">

            <?php
            $arr = array(
                ["title" => "Home", "url" => "./"],
                ["title" => "Dashboard", "url" => "#"],
            );
            renderHeader('Dashboard', $arr);
            ?>

            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-3 col-6">

                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>150</h3>

                                    <p>New Orders</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">

                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>53<sup style="font-size: 20px">%</sup></h3>

                                    <p>Bounce Rate</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>44</h3>

                                    <p>User Registrations</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-6">

                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3>65</h3>

                                    <p>Unique Visitors</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>

                        </div>
                    </div>

                </div>

            </section>
        </div>


    </div>


    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
