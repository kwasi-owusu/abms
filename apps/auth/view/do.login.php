<?php
require_once dirname(__DIR__, 2) . '/template/statics/head.php';

require_once dirname(__DIR__) . '/controller/AuthEnums.php';
require_once dirname(__DIR__) . '/controller/CTRLSecureLogin.php';

$page_name          = AuthEnums::login_page_name->value;
$hash_key           = AuthEnums::secure_form_cors_hash->value;


$create_token       = new CTRLSecureLogin();
$login_token        = $create_token->is_login_has_valid($page_name, $hash_key); 
$_SESSION['login_tkn'] = $login_token;

?>

<body>
    <!-- auth-page wrapper -->
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mb-4">
                                                <a href="javascript:void(0);" class="d-block">
                                                    <img src="apps/template/statics/assets/images/logo.png" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Sign In</h5>
                                        </div>

                                        <div class="mt-4">
                                            <form action="CTRLLoginUser" method="post" name="user_loginForm" class="form-horizontal form" id="user_loginForm" autocomplete="off">

                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="username" name="user_email" placeholder="Enter username">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">Password</label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input type="password" class="form-control pe-5" placeholder="Enter password" id="user_password" name="user_password">
                                                        <input type="hidden" class="form-control pe-5" id="tkn" value="<?php echo $login_token; ?>" name="tkn" id="tkn">
                                                    </div>
                                                </div>
                                                
                                                <div class="mt-4">
                                                    <button class="btn btn-warning w-100" type="submit" id="saveBtn" name="saveBtn">Sign In</button>
                                                </div>

                                            </form>
                                        </div>

                                        <hr />

                                        <div class="col-12">
                                            <div class="loader multi-loader mx-auto" style="display: none;" id="loader"></div>
                                        </div>

                                        <div class="col-12">
                                            <p id="responseHere"></p>
                                        </div>

                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0" style="color: #000;">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> Agency Banking Management System.
                                Powered by <a class="text-white" href="https://www.bsystemslimited.com" target="_blank" style="color: #000;">Bsystems Limited</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->
    <?php
    require_once dirname(__DIR__, 2) . '/template/statics/footer_script.php';
    ?>

    <script src="apps/auth/js/auth.js"></script>

</body>

</html>