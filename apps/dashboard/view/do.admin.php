<?php

require_once dirname(__DIR__, 2) . '/template/statics/head.php';

if (!isset($_SESSION["isLogin"])) {
    echo '<script>
			window.location = "home";
		</script>';
}

require_once dirname(__DIR__, 2) . '/auth/enums/AuthEnums.php';
require_once dirname(__DIR__, 2) . '/auth/controller/CTRLSecureLogin.php';

$page_name          = AuthEnums::login_page_name->value;
$hash_key           = AuthEnums::secure_form_cors_hash->value;


$create_token       = new CTRLSecureLogin();
$login_token        = $create_token->is_login_hash_valid($page_name, $hash_key);
$_SESSION['login_tkn'] = $login_token;


require_once dirname(__DIR__) . '/controller/CTRLDashboard.php';

$transactions_for_today = new CTRLDashboard();

$transactions = $transactions_for_today->transactions_for_today();
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
                                    <img src="apps/template/statics/assets/images/logo.png" alt="" width="150">
                                </span>
                                <span class="logo-lg">
                                    <img src="apps/template/statics/assets/images/logo.png" alt="" width="150">
                                </span>
                            </a>
                            <!-- Light Logo-->
                            <a href="javascript:void(0);" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="apps/template/statics/assets/images/logo.png" alt="" width="150">
                                </span>
                                <span class="logo-lg">
                                    <img src="apps/template/statics/assets/images/logo.png" alt="" width="150">
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

                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?></span>
                                    </span>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <h6 class="dropdown-header">Welcome <?php echo $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?>!</h6>
                                <a class="dropdown-item" href="profile"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profile</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Logout</span></a>
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
                <?php

                require_once dirname(__DIR__, 2) . '/template/statics/menu.php';
                ?>
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
                                <h4 class="mb-sm-0">Dashboard</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xxl-6">
                            <div class="d-flex flex-column h-100">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-muted mb-0">Total Users</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold" id="total_active_users"></h2>
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
                                                        <h2 class="mt-4 ff-secondary fw-semibold" id="total_users_online"></h2>
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
                                                        <h2 class="mt-4 ff-secondary fw-semibold" id="total_agencies"></h2>
                                                        </h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                                <i data-feather="cpu" class="text-info"></i>
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
                                                        <h2 class="mt-4 ff-secondary fw-semibold" id="total_active_branches"></h2>
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

                        <div class="col-xxl-6">
                            <div class="d-flex flex-column h-100">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-muted mb-0">Total Cr. Transactions</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold" style="color: #092;" id="total_cr_transactions_for_today"></h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                                <i data-feather="coffee" class="text-info"></i>
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
                                                        <p class="fw-medium text-muted mb-0">Total Dr. Transactions </p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold" style="color: #d70900;" id="total_dr_transactions_for_today"></h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                                <i data-feather="minus-circle" class="text-info"></i>
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
                                                        <p class="fw-medium text-muted mb-0">Total Sum Dr Transactions</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold" style="color: #d70900;" id="total_sum_dr_for_today"></h2>
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
                                                        <p class="fw-medium text-muted mb-0">Total Sum Cr Transactions</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold" style="color: #092;" id="total_sum_cr_for_today"></h2>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                                <i data-feather="minus-square" class="text-info"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
                                </div> <!-- end row-->
                            </div>
                        </div>
                        <!-- end col -->
                    </div> <!-- end row-->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Credit Transactions Trend (This Year) </h4>
                                </div><!-- end card header -->
                                <div class="card-header p-0 border-0 bg-soft-light">
                                    <div class="row g-0 text-center">

                                        <!--end col-->

                                        <!--end col-->
                                    </div>
                                </div><!-- end card header -->
                                <div class="card-body p-0 pb-2">
                                    <div>
                                        <div id="credit_trends_metrics" data-colors='["--vz-success", "--vz-gray-300"]' class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-6">
                            <div class="card card-height-100">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Debit Transactions Trend (This Year) </h4>
                                </div>

                                <div class="card-body p-0">
                                    <div>
                                        <div id="debit_trends_metrics" data-colors='["--vz-success", "--vz-info"]' class="apex-charts" dir="ltr">
                                        </div>
                                    </div>
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div><!-- end row -->

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Top 10 Performing Agencies</h4>
                                </div><!-- end card header -->
                                <div class="card-header p-0 border-0 bg-soft-light">
                                    <div class="row g-0 text-center">

                                        <!--end col-->

                                        <!--end col-->
                                    </div>
                                </div><!-- end card header -->
                                <div class="card-body p-0 pb-2">
                                    <div>
                                        <div id="transaction_metrics_by_regions" data-colors='["--vz-success", "--vz-gray-300"]' class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div><!-- end col -->

                        <div class="col-xl-6">
                            <div class="card card-height-100">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Top 10 Performing Agencies (Cr/Dr Analysis(</h4>
                                </div>

                                <div class="card-body p-0">
                                    <div>
                                        <div id="credit_debit_volume" data-colors='["--vz-success", "--vz-info"]' class="apex-charts" dir="ltr">
                                        </div>
                                    </div>
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Transactions for Today</h5>
                                    <?php
                                    $dt = DATE('Y-m-d');
                                    //$tdy = strtotime($dt);

                                    echo $dt;
                                    ?>
                                </div>
                                <div class="card-body">
                                    <table id="buttons-datatables" class="display table buttons-datatables" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Agent Name</th>
                                                <th>Branch</th>
                                                <th>Transaction Type</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Transaction Status</th>
                                            </tr>
                                        </thead>

                                        <tfoot>
                                            <tr>
                                                <th>Agent Name</th>
                                                <th>Branch</th>
                                                <th>Transaction Type</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                                <th>Transaction Status</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <?php
                                            foreach ($transactions as $trn) {
                                                $db_date = $trn['transaction_date'];
                                                $dt     = strtotime($db_date);
                                                $trans_date = DATE('Y-m-d', $dt);
                                            ?>
                                                <tr>
                                                    <td><?php echo $trn['agency_name']; ?></td>
                                                    <td><?php echo $trn['branch_name']; ?></td>
                                                    <td><?php echo $trn['TransactionType']; ?></td>
                                                    <td><?php echo number_format($trn['total_amount'], 2); ?></td>
                                                    <td><?php echo $trans_date; ?></td>
                                                    <td><?php echo $trn['TransactionStatus']; ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

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
                                Design & Developed by <a href="https://www.bsystemslimited.com" target="_blank">Bsystems
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
    <script src="apps/dashboard/js/credit_trends_chart.js"></script>
    <script src="apps/dashboard/js/debit_trends_chart.js"></script>

    <script src="apps/dashboard/js/credit_debit_volume_chart.js"></script>
    <script src="apps/dashboard/js/transaction_metrics_by_regions_chart.js"></script>

</body>

</html>