<?php
!isset($_SESSION) ? session_start() : null;

date_default_timezone_set("Africa/Accra");

class CTRLLoginUser
{

    private string $table_a;
    private string $table_b;

    public function __construct($table_a, $table_b)
    {
        $this->table_a = $table_a;
        $this->table_b = $table_b;
    }

    public function fetchUsersCtrl()
    {

        //recaptcha v3 begins
        define("RECAPTCHA_V3_SECRET_KEY", '6Lfqc-YhAAAAAK9Fte1g-uqyPyfTZzr-yAWpHJL9');
        $token      = trim(strip_tags($_POST['r_token']));
        $action     = trim(strip_tags($_POST['r_action']));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => RECAPTCHA_V3_SECRET_KEY, 'response' => $token)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $arrResponse = json_decode($response, true);

        var_dump($arrResponse);

        if ($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {


            $error = false;
            $login_user_tkn  = trim(strip_tags($_POST['tkn']));


            require_once dirname(__DIR__, 2) . '/settings/controller/TransactionAccountEnums.php';

            if (isset($_SESSION['login_tkn']) && $_SESSION['login_tkn'] == $login_user_tkn) {

                $user_email     = trim(strip_tags($_POST['user_email']));
                $user_password  = trim(strip_tags($_POST['user_password']));

                if (empty($user_password)) {
                    $error = true;
                    $message        = "Password Cannot be empty.";
                    $error_code     = 112;

                    $response_msg   = array(
                        'error' => true,
                        'message' => $message,
                        'error_code' => $error_code
                    );

                    echo json_encode($response_msg);

                    return;
                } elseif (empty($user_email)) {
                    $error = true;
                    $message        = "Email cannot be empty";
                    $error_code     = 112;

                    $response_msg   = array(
                        'error' => true,
                        'message' => $message,
                        'error_code' => $error_code
                    );

                    echo json_encode($response_msg);

                    return;
                } elseif (!$error) {

                    $password_hash_key      = TransactionHashKeys::password_hash->value;
                    $hashed_password        = hash_hmac('sha512', $user_password,  $password_hash_key);


                    $data   = array(
                        'em' => $user_email,
                        'ps' => $hashed_password
                    );

                    require_once dirname(__DIR__) . '/model/MDLFetchUsers.php';
                    require_once dirname(__DIR__) . '/model/MDLUserActivities.php';
                    $login_obj = new MDLUserActivities();


                    $this_user = new MDLFetchUsers();

                    $fetch_user = $this_user->loginUser($this->table_a, $this->table_a, $data);

                    $count_rows = $fetch_user->rowCount();

                    if ($count_rows > 0) {

                        $user = $fetch_user->fetch(PDO::FETCH_ASSOC);
                        $user_status    = isset($user['user_status']) ? $user['user_status'] : null;
                        $user_role      = isset($user['user_role']) ? $user['user_role'] : null;

                        if ($user_status == 0) {

                            $activities = array(
                                'actions' => 'Login Attempted',
                                'status' => 'Failed',
                                'usernames' => $user_email
                            );

                            $activity_desc = json_encode($activities);

                            $activity_data = array(
                                'activity_module' => 'User Login',
                                'activity_desc' => $activity_desc,
                                'user_id' => 0
                            );

                            $save_activities = $login_obj->userActivitiesMDL($activity_data, $this->table_b);


                            $message        = "User Access Denied";
                            $error_code     = 112;

                            $response_msg   = array(
                                'error' => true,
                                'message' => $message,
                                'error_code' => $error_code
                            );

                            echo json_encode($response_msg);

                            return;
                        }
                    } else {

                        $activities = array(
                            'actions' => 'Login Attempted',
                            'status' => 'Failed',
                            'usernames' => $user_email
                        );

                        $activity_desc = json_encode($activities);

                        $activity_data = array(
                            'activity_module' => 'User Login',
                            'activity_desc' => $activity_desc,
                            'user_id' => 0
                        );

                        $save_activities = $login_obj->userActivitiesMDL($activity_data, $this->table_b);

                        $message        = "Login Unsuccessful";
                        $error_code     = 112;

                        $response_msg   = array(
                            'error' => true,
                            'message' => $message,
                            'error_code' => $error_code
                        );

                        echo json_encode($response_msg);

                        return;
                    }
                }
            } else {
                $error          = true;
                $message        = "Action not permitted";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);

                return;
            }
        } else {
            $error          = true;
            $message        = "L1 Action not permitted ";
            $error_code     = 112;

            $response_msg   = array(
                'error' => true,
                'message' => $message,
                'error_code' => $error_code
            );

            echo json_encode($response_msg);

            return;
        }
    }
}

$callClass = new CTRLLoginUser('abms_users', 'user_activities');
$callMethod = $callClass->fetchUsersCtrl();
