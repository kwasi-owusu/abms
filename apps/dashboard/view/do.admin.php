<?php
require_once dirname(__DIR__, 2) . '/template/statics/head.php';

require_once dirname(__DIR__, 2) . '/auth/controller/AuthEnums.php';
require_once dirname(__DIR__, 2) . '/auth/controller/CTRLSecureLogin.php';

$page_name          = AuthEnums::login_page_name->value;
$hash_key           = AuthEnums::secure_form_cors_hash->value;


$create_token       = new CTRLSecureLogin();
$login_token        = $create_token->is_login_hash_valid($page_name, $hash_key);
$_SESSION['login_tkn'] = $login_token;

?>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <!-- Dark Logo-->
                            <a href="javascript:void(0);" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="apps/templates/assets/images/logo.png" alt="" width="60">
                                </span>
                                <span class="logo-lg">
                                    <img src="apps/template/assets/images/logo.png" alt="" width="60">
                                </span>
                            </a>
                            <!-- Light Logo-->
                            <a href="javascript:void(0);" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="apps/template/assets/images/logo.png" alt="" width="60">
                                </span>
                                <span class="logo-lg">
                                    <img src="apps/template/assets/images/logo.png" alt="" width="60">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>

                        <div class="app-search position-relative">
                            <h2>AGENCY BANKING MANAGEMENT SOLUTION</h2>
                        </div>

                    </div>

                    <div class="d-flex align-items-center">

                        <div class="dropdown d-md-none topbar-head-dropdown header-item">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-search fs-22"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                            <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                                <i class='bx bx-fullscreen fs-22'></i>
                            </button>
                        </div>

                        <div class="ms-1 header-item d-none d-sm-flex">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                                <i class='bx bx-moon fs-22'></i>
                            </button>
                        </div>

                        <div class="dropdown topbar-head-dropdown ms-1 header-item">
                            <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class='bx bx-bell fs-22'></i>
                                <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">3<span class="visually-hidden">unread messages</span></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                                <div class="dropdown-head bg-primary bg-pattern rounded-top">
                                    <div class="p-3">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-0 fs-16 fw-semibold text-white"> Notifications </h6>
                                            </div>
                                            <div class="col-auto dropdown-tabs">
                                                <span class="badge badge-soft-light fs-13"> 4 New</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="px-2 pt-2">
                                        <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab" role="tab" aria-selected="true">
                                                    All (4)
                                                </a>
                                            </li>
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-bs-toggle="tab" href="#messages-tab" role="tab" aria-selected="false">
                                                    Messages
                                                </a>
                                            </li>
                                            <li class="nav-item waves-effect waves-light">
                                                <a class="nav-link" data-bs-toggle="tab" href="#alerts-tab" role="tab" aria-selected="false">
                                                    Alerts
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                </div>

                                <div class="tab-content" id="notificationItemsTabContent">
                                    <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                        <div data-simplebar style="max-height: 300px;" class="pe-2">
                                            <div class="text-reset notification-item d-block dropdown-item position-relative">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-soft-info text-info rounded-circle fs-16">
                                                            <i class="bx bx-badge-check"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <a href="#!" class="stretched-link">
                                                            <h6 class="mt-0 mb-2 lh-base">Your <b>Elite</b> author
                                                                Graphic
                                                                Optimization <span class="text-secondary">reward</span>
                                                                is
                                                                ready!
                                                            </h6>
                                                        </a>
                                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                            <span><i class="mdi mdi-clock-outline"></i> Just 30 sec
                                                                ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="px-2 fs-15">
                                                        <div class="form-check notification-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="all-notification-check01">
                                                            <label class="form-check-label" for="all-notification-check01"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-reset notification-item d-block dropdown-item position-relative active">
                                                <div class="d-flex">
                                                    <img src="assets/images/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                    <div class="flex-1">
                                                        <a href="#!" class="stretched-link">
                                                            <h6 class="mt-0 mb-1 fs-13 fw-semibold">Angela Bernier</h6>
                                                        </a>
                                                        <div class="fs-13 text-muted">
                                                            <p class="mb-1">Answered to your comment on the cash flow
                                                                forecast's
                                                                graph 🔔.</p>
                                                        </div>
                                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                            <span><i class="mdi mdi-clock-outline"></i> 48 min
                                                                ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="px-2 fs-15">
                                                        <div class="form-check notification-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="all-notification-check02" checked>
                                                            <label class="form-check-label" for="all-notification-check02"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-reset notification-item d-block dropdown-item position-relative">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3">
                                                        <span class="avatar-title bg-soft-danger text-danger rounded-circle fs-16">
                                                            <i class='bx bx-message-square-dots'></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <a href="#!" class="stretched-link">
                                                            <h6 class="mt-0 mb-2 fs-13 lh-base">You have received <b class="text-success">20</b> new messages in the
                                                                conversation
                                                            </h6>
                                                        </a>
                                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                            <span><i class="mdi mdi-clock-outline"></i> 2 hrs ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="px-2 fs-15">
                                                        <div class="form-check notification-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="all-notification-check03">
                                                            <label class="form-check-label" for="all-notification-check03"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-reset notification-item d-block dropdown-item position-relative">
                                                <div class="d-flex">
                                                    <img src="assets/images/users/avatar-8.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                    <div class="flex-1">
                                                        <a href="#!" class="stretched-link">
                                                            <h6 class="mt-0 mb-1 fs-13 fw-semibold">Maureen Gibson</h6>
                                                        </a>
                                                        <div class="fs-13 text-muted">
                                                            <p class="mb-1">We talked about a project on linkedin.</p>
                                                        </div>
                                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                            <span><i class="mdi mdi-clock-outline"></i> 4 hrs ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="px-2 fs-15">
                                                        <div class="form-check notification-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="all-notification-check04">
                                                            <label class="form-check-label" for="all-notification-check04"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="my-3 text-center">
                                                <button type="button" class="btn btn-soft-success waves-effect waves-light">View
                                                    All Notifications <i class="ri-arrow-right-line align-middle"></i></button>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="tab-pane fade py-2 ps-2" id="messages-tab" role="tabpanel" aria-labelledby="messages-tab">
                                        <div data-simplebar style="max-height: 300px;" class="pe-2">
                                            <div class="text-reset notification-item d-block dropdown-item">
                                                <div class="d-flex">
                                                    <img src="assets/images/users/avatar-3.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                    <div class="flex-1">
                                                        <a href="#!" class="stretched-link">
                                                            <h6 class="mt-0 mb-1 fs-13 fw-semibold">James Lemire</h6>
                                                        </a>
                                                        <div class="fs-13 text-muted">
                                                            <p class="mb-1">We talked about a project on linkedin.</p>
                                                        </div>
                                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                            <span><i class="mdi mdi-clock-outline"></i> 30 min
                                                                ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="px-2 fs-15">
                                                        <div class="form-check notification-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="messages-notification-check01">
                                                            <label class="form-check-label" for="messages-notification-check01"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-reset notification-item d-block dropdown-item">
                                                <div class="d-flex">
                                                    <img src="assets/images/users/avatar-2.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                    <div class="flex-1">
                                                        <a href="#!" class="stretched-link">
                                                            <h6 class="mt-0 mb-1 fs-13 fw-semibold">Angela Bernier</h6>
                                                        </a>
                                                        <div class="fs-13 text-muted">
                                                            <p class="mb-1">Answered to your comment on the cash flow
                                                                forecast's
                                                                graph 🔔.</p>
                                                        </div>
                                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                            <span><i class="mdi mdi-clock-outline"></i> 2 hrs ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="px-2 fs-15">
                                                        <div class="form-check notification-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="messages-notification-check02">
                                                            <label class="form-check-label" for="messages-notification-check02"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-reset notification-item d-block dropdown-item">
                                                <div class="d-flex">
                                                    <img src="assets/images/users/avatar-6.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                    <div class="flex-1">
                                                        <a href="#!" class="stretched-link">
                                                            <h6 class="mt-0 mb-1 fs-13 fw-semibold">Kenneth Brown</h6>
                                                        </a>
                                                        <div class="fs-13 text-muted">
                                                            <p class="mb-1">Mentionned you in his comment on 📃 invoice
                                                                #12501.
                                                            </p>
                                                        </div>
                                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                            <span><i class="mdi mdi-clock-outline"></i> 10 hrs
                                                                ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="px-2 fs-15">
                                                        <div class="form-check notification-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="messages-notification-check03">
                                                            <label class="form-check-label" for="messages-notification-check03"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="text-reset notification-item d-block dropdown-item">
                                                <div class="d-flex">
                                                    <img src="assets/images/users/avatar-8.jpg" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                                    <div class="flex-1">
                                                        <a href="#!" class="stretched-link">
                                                            <h6 class="mt-0 mb-1 fs-13 fw-semibold">Maureen Gibson</h6>
                                                        </a>
                                                        <div class="fs-13 text-muted">
                                                            <p class="mb-1">We talked about a project on linkedin.</p>
                                                        </div>
                                                        <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                            <span><i class="mdi mdi-clock-outline"></i> 3 days
                                                                ago</span>
                                                        </p>
                                                    </div>
                                                    <div class="px-2 fs-15">
                                                        <div class="form-check notification-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="messages-notification-check04">
                                                            <label class="form-check-label" for="messages-notification-check04"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="my-3 text-center">
                                                <button type="button" class="btn btn-soft-success waves-effect waves-light">View
                                                    All Messages <i class="ri-arrow-right-line align-middle"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade p-4" id="alerts-tab" role="tabpanel" aria-labelledby="alerts-tab">
                                        <div class="w-25 w-sm-50 pt-3 mx-auto">
                                            <img src="assets/images/svg/bell.svg" class="img-fluid" alt="user-pic">
                                        </div>
                                        <div class="text-center pb-5 mt-2">
                                            <h6 class="fs-18 fw-semibold lh-base">Hey! You have no any notifications
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">Uesrname</span>
                                        <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Admin</span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">Welcome Username!</h6>
                                <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="pages-profile.html"><i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Balance : <b>$5971.67</b></span></a>
                                <a class="dropdown-item" href="pages-profile-settings.html"><span class="badge bg-soft-success text-success mt-1 float-end">New</span><i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Settings</span></a>
                                <a class="dropdown-item" href="auth-lockscreen-basic.html"><i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Lock screen</span></a>
                                <a class="dropdown-item" href="auth-logout-basic.html"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="admin" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="apps/template/assets/images/logo.png" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="apps/template/assets/images/logo.png" alt="">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="admin" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="apps/template/assets/images/logo.png" alt="">
                    </span>
                    <span class="logo-lg">
                        <img src="apps/template/assets/images/logo.png" alt="">
                    </span>
                </a>

                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="dashboard2.html">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                            </a>
                        </li> <!-- end Dashboard Menu -->
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#">
                                <i class="ri-apps-2-line"></i> <span data-key="t-apps">Partner Application</span>
                            </a>
                        </li> <!-- end Dashboard Menu -->
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#">
                                <i class="ri-apps-2-line"></i> <span data-key="t-apps">My Applications</span>
                            </a>
                        </li> <!-- end Dashboard Menu -->
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarApps" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarApps">
                                <i class="ri-apps-2-line"></i> <span data-key="t-apps">User Management</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarApps">
                                <ul class="nav nav-sm flex-column sub">
                                    <li class="nav-item">
                                        <a href="#sidebarProjects" class="nav-link" data-key="t-projects">
                                            Add User
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#sidebarProjects" class="nav-link" data-key="t-projects">
                                            Manage User
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#sidebarProjects" class="nav-link" data-key="t-projects">
                                            My Account
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                                <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Branches</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarLayouts">
                                <ul class="nav nav-sm flex-column sub">
                                    <li class="nav-item">
                                        <a href="cash_inventory_type.html" target="_blank" class="nav-link" data-key="t-horizontal">Edit Branch</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                                <i class="ri-layout-3-line"></i> <span data-key="t-layouts">Transactions</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarLayouts">
                                <ul class="nav nav-sm flex-column sub">
                                    <li class="nav-item">
                                        <a href="cash_inventory_type.html" target="_blank" class="nav-link" data-key="t-horizontal">Select Opening Balance</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="cash_inventory_type.html" target="_blank" class="nav-link" data-key="t-horizontal">Buy E-Cash</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="cash_inventory_type.html" target="_blank" class="nav-link" data-key="t-horizontal">Sell & Buy Cash</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="cash_inventory_type.html" target="_blank" class="nav-link" data-key="t-horizontal">E-Cash to Cash</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                                <i class="ri-account-circle-line"></i> <span data-key="t-authentication">Approvals</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarAuth">
                                <ul class="nav nav-sm flex-column sub">
                                    <li class="nav-item">
                                        <a href="daily_trends.html" target="_blank" class="nav-link" data-key="t-horizontal">Approve Users</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="monthly_trends.html" target="_blank" class="nav-link" data-key="t-detached">Approve Branches</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item sub">
                            <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                                <span data-key="t-authentication">Reports</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarAuth">
                                <ul class="nav nav-sm flex-column sub">
                                    <li class="nav-item">
                                        <a href="daily_trends.html" target="_blank" class="nav-link" data-key="t-horizontal">Activity Report</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="monthly_trends.html" target="_blank" class="nav-link" data-key="t-detached">Cash In Hand Report</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="monthly_trends.html" target="_blank" class="nav-link" data-key="t-detached">E-Cash Transaction Report</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#sidebarProjects" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProjects" data-key="t-projects">
                                            Transaction Report
                                        </a>
                                        <div class="collapse menu-dropdown" id="sidebarProjects">
                                            <ul class="nav nav-sm flex-column sub">
                                                <li class="nav-item">
                                                    <a href="buy_cash.html" class="nav-link" data-key="t-list"> UBA
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#sidebarProjects" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarProjects" data-key="t-projects">
                                            Commission Report
                                        </a>
                                        <div class="collapse menu-dropdown" id="sidebarProjects">
                                            <ul class="nav nav-sm flex-column sub">
                                                <li class="nav-item">
                                                    <a href="buy_cash.html" class="nav-link" data-key="t-list"> UBA
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item sub">
                            <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                                <span data-key="t-authentication">Settings</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarAuth">
                                <ul class="nav nav-sm flex-column sub">
                                    <li class="nav-item">
                                        <a href="daily_trends.html" target="_blank" class="nav-link" data-key="t-horizontal">Activate Product</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="monthly_trends.html" target="_blank" class="nav-link" data-key="t-detached">Setup Branches</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="monthly_trends.html" target="_blank" class="nav-link" data-key="t-detached">Set Transaction Limit Alert</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Horizontal</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Layouts</a></li>
                                        <li class="breadcrumb-item active">Horizontal</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xxl-5">
                            <div class="d-flex flex-column h-100">
                                <div class="row h-100">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body p-0">
                                                <div class="alert alert-warning border-0 rounded-0 m-0 d-flex align-items-center" role="alert">
                                                    <i data-feather="alert-triangle" class="text-warning me-2 icon-sm"></i>
                                                    <div class="flex-grow-1 text-truncate">
                                                        Your free trial expired in <b>17</b> days.
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <a href="pages-pricing.html" class="text-reset text-decoration-underline"><b>Upgrade</b></a>
                                                    </div>
                                                </div>

                                                <div class="row align-items-end">
                                                    <div class="col-sm-8">
                                                        <div class="p-3">
                                                            <p class="fs-16 lh-base">Upgrade your plan from a <span class="fw-semibold">Free trial</span>, to ‘Premium
                                                                Plan’ <i class="mdi mdi-arrow-right"></i></p>
                                                            <div class="mt-3">
                                                                <a href="pages-pricing.html" class="btn btn-success">Upgrade Account!</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="px-3">
                                                            <img src="assets/images/user-illustarator-2.png" class="img-fluid" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- end card-body-->
                                        </div>
                                    </div> <!-- end col-->
                                </div> <!-- end row-->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-muted mb-0">Total Users</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold">350</h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                                <i data-feather="users" class="text-info"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-muted mb-0">Total Users Online </p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold">151</h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                                <i data-feather="activity" class="text-info"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
                                </div> <!-- end row-->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-muted mb-0">Total Agencies</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold">
                                                            3500
                                                        </h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                                <i data-feather="check-square" class="text-info"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-muted mb-0">Total Branches</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold">
                                                            5402
                                                        </h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                                <i data-feather="external-link" class="text-info"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end col-->

                        <div class="col-xxl-7">
                            <div class="row h-100">
                            <div class="col-xl-6">
                                    <div class="card card-height-100">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Top 10 Agents- by Transaction Volume</h4>
                                        </div>
                                        <div class="card-body p-0">
                                            <div>
                                                <div id="countries_charts" data-colors='["--vz-info", "--vz-info", "--vz-info", "--vz-info", "--vz-danger", "--vz-info", "--vz-info", "--vz-info", "--vz-info", "--vz-info"]' class="apex-charts" dir="ltr"></div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div><!-- end col -->

                                <div class="col-xl-6">
                                    <div class="card card-height-100">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Top 10 Branches- by Transaction Volume</h4>
                                        </div>
                                        <div class="card-body p-0">
                                            <div>
                                                <div id="countries_charts" data-colors='["--vz-info", "--vz-info", "--vz-info", "--vz-info", "--vz-danger", "--vz-info", "--vz-info", "--vz-info", "--vz-info", "--vz-info"]' class="apex-charts" dir="ltr"></div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div> <!-- end col-->

                            </div> <!-- end row-->
                        </div><!-- end col -->
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Audiences Metrics</h4>
                                    <div>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            ALL
                                        </button>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            1M
                                        </button>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            6M
                                        </button>
                                        <button type="button" class="btn btn-soft-primary btn-sm">
                                            1Y
                                        </button>
                                    </div>
                                </div><!-- end card header -->
                                <div class="card-header p-0 border-0 bg-soft-light">
                                    <div class="row g-0 text-center">
                                        <div class="col-6 col-sm-4">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span class="counter-value" data-target="854">0</span>
                                                    <span class="text-success ms-1 fs-12">49%<i class="ri-arrow-right-up-line ms-1 align-middle"></i></span>
                                                </h5>
                                                <p class="text-muted mb-0">Avg. Session</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-4">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span class="counter-value" data-target="1278">0</span>
                                                    <span class="text-success ms-1 fs-12">60%<i class="ri-arrow-right-up-line ms-1 align-middle"></i></span>
                                                </h5>
                                                <p class="text-muted mb-0">Conversion Rate</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-4">
                                            <div class="p-3 border border-dashed border-start-0 border-end-0">
                                                <h5 class="mb-1"><span class="counter-value" data-target="3">0</span>m
                                                    <span class="counter-value" data-target="40">0</span>sec
                                                    <span class="text-success ms-1 fs-12">37%<i class="ri-arrow-right-up-line ms-1 align-middle"></i></span>
                                                </h5>
                                                <p class="text-muted mb-0">Avg. Session Duration</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                </div><!-- end card header -->
                                <div class="card-body p-0 pb-2">
                                    <div>
                                        <div id="audiences_metrics_charts" data-colors='["--vz-success", "--vz-gray-300"]' class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-6">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Audiences Sessions by Country</h4>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown card-header-dropdown">
                                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="fw-semibold text-uppercase fs-12">Sort by: </span><span class="text-muted">Current Week<i class="mdi mdi-chevron-down ms-1"></i></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Today</a>
                                                <a class="dropdown-item" href="#">Last Week</a>
                                                <a class="dropdown-item" href="#">Last Month</a>
                                                <a class="dropdown-item" href="#">Current Year</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card header -->
                                <div class="card-body p-0">
                                    <div>
                                        <div id="audiences-sessions-country-charts" data-colors='["--vz-success", "--vz-info"]' class="apex-charts" dir="ltr">
                                        </div>
                                    </div>
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->

                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Users by Device</h4>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown card-header-dropdown">
                                            <a class="text-reset" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted fs-16"><i class="mdi mdi-dots-vertical align-middle"></i></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Today</a>
                                                <a class="dropdown-item" href="#">Last Week</a>
                                                <a class="dropdown-item" href="#">Last Month</a>
                                                <a class="dropdown-item" href="#">Current Year</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <div id="user_device_pie_charts" data-colors='["--vz-primary", "--vz-warning", "--vz-info"]' class="apex-charts" dir="ltr"></div>

                                    <div class="table-responsive mt-3">
                                        <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-0">
                                            <tbody class="border-0">
                                                <tr>
                                                    <td>
                                                        <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-primary me-2"></i>Desktop
                                                            Users</h4>
                                                    </td>
                                                    <td>
                                                        <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>78.56k</p>
                                                    </td>
                                                    <td class="text-end">
                                                        <p class="text-success fw-medium fs-12 mb-0"><i class="ri-arrow-up-s-fill fs-5 align-middle"></i>2.08%
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-warning me-2"></i>Mobile
                                                            Users</h4>
                                                    </td>
                                                    <td>
                                                        <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>105.02k</p>
                                                    </td>
                                                    <td class="text-end">
                                                        <p class="text-danger fw-medium fs-12 mb-0"><i class="ri-arrow-down-s-fill fs-5 align-middle"></i>10.52%
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-info me-2"></i>Tablet
                                                            Users</h4>
                                                    </td>
                                                    <td>
                                                        <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>42.89k</p>
                                                    </td>
                                                    <td class="text-end">
                                                        <p class="text-danger fw-medium fs-12 mb-0"><i class="ri-arrow-down-s-fill fs-5 align-middle"></i>7.36%
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-4 col-md-6">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Top Referrals Pages</h4>
                                    <div class="flex-shrink-0">
                                        <button type="button" class="btn btn-soft-primary btn-sm">
                                            Export Report
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">

                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <h6 class="text-muted text-uppercase fw-semibold text-truncate fs-12 mb-3">
                                                Total Referrals Page</h6>
                                            <h4 class="fs- mb-0">725,800</h4>
                                            <p class="mb-0 mt-2 text-muted"><span class="badge badge-soft-success mb-0">
                                                    <i class="ri-arrow-up-line align-middle"></i> 15.72 % </span> vs.
                                                previous month</p>
                                        </div><!-- end col -->
                                        <div class="col-6">
                                            <div class="text-center">
                                                <img src="assets/images/illustrator-1.png" class="img-fluid" alt="">
                                            </div>
                                        </div><!-- end col -->
                                    </div><!-- end row -->
                                    <div class="mt-3 pt-2">
                                        <div class="progress progress-lg rounded-pill">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-info" role="progressbar" style="width: 18%" aria-valuenow="18" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-success" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 16%" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100"></div>
                                            <div class="progress-bar bg-danger" role="progressbar" style="width: 19%" aria-valuenow="19" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div><!-- end -->

                                    <div class="mt-3 pt-2">
                                        <div class="d-flex mb-2">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate text-muted fs-14 mb-0">
                                                    <i class="mdi mdi-circle align-middle text-primary me-2"></i>www.google.com
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <p class="mb-0">24.58%</p>
                                            </div>
                                        </div><!-- end -->
                                        <div class="d-flex mb-2">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate text-muted fs-14 mb-0">
                                                    <i class="mdi mdi-circle align-middle text-info me-2"></i>www.youtube.com
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <p class="mb-0">17.51%</p>
                                            </div>
                                        </div><!-- end -->
                                        <div class="d-flex mb-2">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate text-muted fs-14 mb-0">
                                                    <i class="mdi mdi-circle align-middle text-success me-2"></i>www.meta.com
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <p class="mb-0">23.05%</p>
                                            </div>
                                        </div><!-- end -->
                                        <div class="d-flex mb-2">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate text-muted fs-14 mb-0">
                                                    <i class="mdi mdi-circle align-middle text-warning me-2"></i>www.medium.com
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <p class="mb-0">12.22%</p>
                                            </div>
                                        </div><!-- end -->
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-truncate text-muted fs-14 mb-0">
                                                    <i class="mdi mdi-circle align-middle text-danger me-2"></i>Other
                                                </p>
                                            </div>
                                            <div class="flex-shrink-0">
                                                <p class="mb-0">17.58%</p>
                                            </div>
                                        </div><!-- end -->
                                    </div><!-- end -->

                                    <div class="mt-2 text-center">
                                        <a href="javascript:void(0);" class="text-muted text-decoration-underline">Show
                                            All</a>
                                    </div>

                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-4 col-md-6">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Top Pages</h4>
                                    <div class="flex-shrink-0">
                                        <div class="dropdown card-header-dropdown">
                                            <a class="text-reset" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="text-muted fs-16"><i class="mdi mdi-dots-vertical align-middle"></i></span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">Today</a>
                                                <a class="dropdown-item" href="#">Last Week</a>
                                                <a class="dropdown-item" href="#">Last Month</a>
                                                <a class="dropdown-item" href="#">Current Year</a>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table align-middle table-borderless table-centered table-nowrap mb-0">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th scope="col" style="width: 62;">Active Page</th>
                                                    <th scope="col">Active</th>
                                                    <th scope="col">Users</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <a href="javascript:void(0);">/themesbrand/skote-25867</a>
                                                    </td>
                                                    <td>99</td>
                                                    <td>25.3%</td>
                                                </tr><!-- end -->
                                                <tr>
                                                    <td>
                                                        <a href="javascript:void(0);">/dashonic/chat-24518</a>
                                                    </td>
                                                    <td>86</td>
                                                    <td>22.7%</td>
                                                </tr><!-- end -->
                                                <tr>
                                                    <td>
                                                        <a href="javascript:void(0);">/skote/timeline-27391</a>
                                                    </td>
                                                    <td>64</td>
                                                    <td>18.7%</td>
                                                </tr><!-- end -->
                                                <tr>
                                                    <td>
                                                        <a href="javascript:void(0);">/themesbrand/minia-26441</a>
                                                    </td>
                                                    <td>53</td>
                                                    <td>14.2%</td>
                                                </tr><!-- end -->
                                                <tr>
                                                    <td>
                                                        <a href="javascript:void(0);">/dashon/dashboard-29873</a>
                                                    </td>
                                                    <td>33</td>
                                                    <td>12.6%</td>
                                                </tr><!-- end -->
                                                <tr>
                                                    <td>
                                                        <a href="javascript:void(0);">/doot/chats-29964</a>
                                                    </td>
                                                    <td>20</td>
                                                    <td>10.9%</td>
                                                </tr><!-- end -->
                                                <tr>
                                                    <td>
                                                        <a href="javascript:void(0);">/minton/pages-29739</a>
                                                    </td>
                                                    <td>10</td>
                                                    <td>07.3%</td>
                                                </tr><!-- end -->
                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->
                                    </div><!-- end -->
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © UBA - AGENCY BANKING SYSTEM.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by <a href="https://www.bsystemslimited.com" target="_blank">Bsystems
                                    Limited</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->
    <?php
    require_once dirname(__DIR__, 2) . '/template/statics/footer_script.php';
    ?>

<script src="apps/dashboard/js/extra.js"></script>

</body>

</html>