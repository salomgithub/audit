<?php

/** @var \yii\web\View $this */

/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset3;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\ButtonDropdown;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset3::register($this);

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
    <header id="header" class="header fixed-top d-flex align-items-center ">

        <div class="d-flex align-items-center justify-content-between">
            <a href="<?=Yii::$app->homeUrl?>" class="logo d-flex align-items-center">
                <?= Html::img('/img/xb-gold.png', ['alt' => 'Logo', 'width' => '155', 'height' => '285']) ?>
                <span class="d-none d-lg-block"></span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="/main/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?= Yii::$app->user->identity->username ?></span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?= Yii::$app->user->identity->username ?></h6>
                        <span>Audit Hodimi</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="/site/change_password">
                            <i class="bi bi-gear"></i>
                            <span> Парол ўзгартириш</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="bi bi-box-arrow-right"></i>
                            <?php
                            if (Yii::$app->user->isGuest) {
                                echo Html::tag('div', Html::a('Login', ['/site/login'], ['class' => ['btn btn-link login text-decoration-none']]), ['class' => ['d-flex']]);
                            } else {
                                echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
                                    . Html::submitButton(
                                        'Logout (' . Yii::$app->user->identity->username . ')',
                                        ['class' => 'btn btn-link logout text-decoration-none']
                                    )
                                    . Html::endForm();
                            }
                            ?>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <?= Html::a('<i class="bi bi-grid"></i>Дашбоард', '/dashboard/dashboard', ['class' => 'nav-link']) ?>
            </li><!-- End Dashboard Nav -->
            <li class="nav-item">
                <a class="nav-link <?= in_array(Yii::$app->controller->id, ['work', 'worklist', 'permission']) ? '' : 'collapsed' ?>"
                   data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-menu-button-wide"></i><span>Aудит Текшируви натижалари</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav"
                    class="nav-content collapse <?= in_array(Yii::$app->controller->id, ['work', 'worklist', 'permission']) ? 'show' : '' ?>"
                    data-bs-parent="#sidebar-nav">
                    <?php foreach ($tekshiruv as $item): ?>
                        <li class="nav-item">
                            <?= Html::a($item['label'], $item['url'], ['class' => 'nav-link']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li><!-- Audit Tekshiruvi natijalari -->
            <li class="nav-item">
                <a class="nav-link  <?= in_array(Yii::$app->controller->id, ['dashboard','kpi', 'akt', 'davomat', 'kunlik', 'orders']) ? '' : 'collapsed' ?> "
                   data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i><span>Ҳисоботлар</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="tables-nav"
                    class="nav-content collapse <?= in_array(Yii::$app->controller->id, ['dashboard','kpi', 'akt', 'davomat', 'kunlik', 'orders',]) ? 'show' : '' ?>"
                    data-bs-parent="#sidebar-nav">
                    <?php foreach ($hisobot as $item): ?>
                        <li class="nav-item">
                            <?= Html::a($item['label'], $item['url'], ['class' => 'nav-link']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li><!-- Hisobotlar -->
            <li class="nav-item">
                <a class="nav-link <?= in_array(Yii::$app->controller->id, ['user','site', 'role', 'assignment', 'permission', 'route', 'rule', 'menu', 'branches', 'mistakes', 'doc-log', 'departaments']) ? '' : 'collapsed' ?>"
                   data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-journal-text"></i><span>Созланмалар</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="forms-nav"
                    class="nav-content collapse <?= in_array(Yii::$app->controller->id, ['user', 'site', 'role', 'assignment', 'permission', 'route', 'rule', 'menu', 'branches', 'mistakes', 'doc-log', 'departaments']) ? 'show' : '' ?>"
                    data-bs-parent="#sidebar-nav">
                    <?php foreach ($users as $item): ?>
                        <li class="nav-item">
                            <?= Html::a($item['label'], $item['url'], ['class' => 'nav-link bg-red']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li><!-- Sozlanmalar -->
            <li class="nav-item ">
                <a class="nav-link <?= in_array(Yii::$app->controller->id, ['finance', 'balance']) ? '' : 'collapsed' ?>"
                   data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-bar-chart"></i><span>Молиявий Тахлил</span><i
                            class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="charts-nav"
                    class="nav-content collapse <?= in_array(Yii::$app->controller->id, ['finance', 'balance']) ? 'show' : '' ?> "
                    data-bs-parent="#sidebar-nav">
                    <?php foreach ($moliyaviy_tahlil as $item): ?>
                        <li class="nav-item">
                            <?= Html::a($item['label'], $item['url'], ['class' => 'nav-link']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li><!-- Kamchiliklarni kiritish -->
        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">


        <?= $content ?>

    </main><!-- End #main -->


    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
