<?php
require_once dirname(__DIR__, 2) . '/template/statics/head.php';

require_once dirname(__DIR__) . '/controller/AuthEnums.php';
require_once dirname(__DIR__) . '/controller/CTRLSecureLogin.php';

$page_name          = AuthEnums::login_page_name->value;
$hash_key           = AuthEnums::secure_form_cors_hash->value;


$create_token       = new CTRLSecureLogin();
$login_token        = $create_token->is_login_hash_valid($page_name, $hash_key);
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
                                                    <img src="apps/template/assets/images/ubalogo.png" alt="" width="100">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->

                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div>
                                            <h5 class="text-primary">Welcome!</h5>
                                            <p class="text-muted">Sign in to continue to UBA Agency Management System.
                                            </p>
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
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-danger w-100" type="submit" id="saveBtn" name="saveBtn">Sign In</button>
                                                </div>

                                            </form>

                                        </div>

                                        <p></p>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="loader multi-loader mx-auto" style="display: none;" id="loader"></div>
                                            </div>
                                        </div>


                                        <p id="responseHere"></p>
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
                            <p class="mb-0">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> UBA Agency Management System.
                                Designed and Developed by <a class="text-dark" href="https://www.bsystemslimited.com">Bsystems Limited</a>
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