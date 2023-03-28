<?php
!isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__, 1) . '/model/MDLUpdateUserPassword.php';
require_once dirname(__DIR__, 1) . '/enums/AuthEnums.php';
require_once dirname(__DIR__, 2) . '/settings/enums/TransactionAccountEnums.php';

date_default_timezone_set("Africa/Accra");

class CTRLUpdateMyPasswordController
{

    private string $table_a;
    private string $table_b;

    public function __construct($table_a, $table_b)
    {
        $this->table_a = $table_a;
        $this->table_b = $table_b;
    }

    public function update_my_password()
    {

        $error = false;
        $login_user_tkn  = trim(strip_tags($_POST['tkn']));

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();


        if (isset($_SESSION['login_tkn']) && $_SESSION['login_tkn'] == $login_user_tkn) {

            $new_password     = trim(strip_tags($_POST['new_password']));
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
            } elseif (empty($new_password)) {
                $error = true;
                $message        = "Password cannot be empty";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);

                return;
            } elseif ($new_password !== $user_password) {
                $error = true;
                $message        = "Passwords do not match";
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

                $officer_id = $_SESSION['officer_id'];

                $data = array(
                    'user_id' => $officer_id,
                    'ps' => $hashed_password
                );

                $instance_of_update_user = new MDLUpdateUserPassword($newPDO, $thisPDO);

                $check_if_user_is_active = $instance_of_update_user->is_user_still_active($data, $this->table_a);

                if ($check_if_user_is_active == 1) {

                    if ($instance_of_update_user->change_user_password($this->table_a, $this->table_b, $data)) {

                        $error          = false;
                        $message        = "Update Successful";
                        $error_code     = 111;

                        $response_msg   = array(
                            'error' => false,
                            'message' => $message,
                            'error_code' => $error_code
                        );

                        echo json_encode($response_msg);

                        return;
                        
                    } else {
                        $error          = true;
                        $message        = "Update Unsuccessful";
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

                else {
                    $error          = true;
                    $message        = "User cannot be accounted for.";
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
    }
}

$call_class = new CTRLUpdateMyPasswordController('abms_users', 'password_logs');
$call_method = $call_class->update_my_password();
