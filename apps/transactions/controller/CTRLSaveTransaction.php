<?php

!isset($_SESSION) ? session_start() : null;

date_default_timezone_set("Africa/Accra");

require_once dirname(__DIR__) . '/controller/CTRLSecureTransaction.php';
require_once dirname(__DIR__, 2) . '/auth/model/MDLUserActivities.php';


class CTRLSaveTransactions
{

    //tables
    private string $transactions_tbl;
    private string $user_activities;
    private string $notifications;
    private string $agency_branches;

    private string $agency_setup;
    private string $abms_users;
    private string $geneal_settings;


    function __construct($transactions_tbl, $user_activities, $notifications, $agency_branches, $agency_setup, $abms_users, $geneal_settings)
    {

        $this->transactions_tbl = $transactions_tbl;
        $this->user_activities = $user_activities;
        $this->notifications = $notifications;
        $this->agency_branches = $agency_branches;

        $this->agency_setup = $agency_setup;
        $this->abms_users = $abms_users;
        $this->geneal_settings = $geneal_settings;
    }


    public function saveTransaction()
    {

        $error = false;
        $transaction_token          = trim(strip_tags($_POST['tkn']));

        if (isset($_SESSION['tkn']) && $_SESSION['tkn'] == $transaction_token) {

            //require_once '../../settings/controller/TransactionAccountEnums.php';
            require_once dirname(__DIR__, 2) . '/settings/controller/TransactionAccountEnums.php';
            //properties
            $transaction_type           = trim(strip_tags($_POST['transaction_type']));
            $transaction_category       = trim(strip_tags($_POST['transaction_category']));
            $product_id                 = trim(strip_tags($_POST['product_id']));
            $partner_id                 = trim(strip_tags($_POST['partner_id']));
            $unit_price                 = trim(strip_tags($_POST['unit_price']));
            $total_qty                  = trim(strip_tags($_POST['total_qty']));
            $total_amount               = trim(strip_tags($_POST['total_amount']));
            $officer_id                 = trim(strip_tags($_SESSION['officer_id']));
            $narration                  = trim(strip_tags($_POST['narration']));
            $id_type                    = trim(strip_tags($_POST['id_type']));
            $id_number                  = trim(strip_tags($_POST['id_number']));

            $transaction_hash_key       = TransactionHashKeys::save_transaction->value;
            $account_name               = hash_hmac('sha512', trim(strip_tags($_POST['account_name'])),  $transaction_hash_key);
            $account_number             = hash_hmac('sha512', trim(strip_tags($_POST['account_number'])),  $transaction_hash_key);


            $agency_branch              = trim(strip_tags($_SESSION['agency_branch']));
            $agent_id                   = trim(strip_tags($_SESSION['agency_id']));

            $depositor_payee            = trim(strip_tags($_POST['depositor_payee']));
            $depositor_payee_phone      = trim(strip_tags($_POST['depositor_payee_phone']));

            $branch_key                 = trim(strip_tags($_SESSION['branch_key']));
            $agent_key                  = trim(strip_tags($_SESSION['agent_key']));
            $user_key                   = trim(strip_tags($_SESSION['user_key']));

            $current_transaction_limit  = trim(strip_tags($_SESSION['current_transaction_limit']));

            $activity_module            = "Transaction";
            $activity_desc              = "New Transaction Saved";

            $this_transaction_type = "";
            switch ($transaction_type) {
                case 1:
                    $this_transaction_type .= "Deposit";
                    break;

                case 2:
                    $this_transaction_type .= "Withdrawal";
                    break;

                case 3:
                    $this_transaction_type .= "Third party deposit";
                    break;

                case 4:
                    $this_transaction_type .= "Local Money Transfer";
                    break;

                case 5:
                    $this_transaction_type .= "International Money Transfer";
                    break;
            }


            $notification_desc          = "A $this_transaction_type transaction has occured on your account";
            $notification_type          = "Email";
            $send_to                    = "";


            $n = 10;
            function transaction_reference($n)
            {
                $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $transaction_ref = '';

                for ($i = 0; $i < $n; $i++) {
                    $index = rand(0, strlen($characters) - 1);
                    $transaction_ref .= $characters[$index];
                }

                return $transaction_ref;
            }

            $transaction_reference =  transaction_reference($n);

            $toHashThis                 = $account_name . $account_name . $total_amount;
            $transaction_key            = hash_hmac('sha512', $toHashThis, $transaction_reference);


            //check for empty
            if (
                empty($transaction_type) || empty($transaction_category) || empty($product_id) || empty($total_amount) || empty($officer_id)
                || empty($depositor_payee) || empty($id_type) || empty($id_number) || empty($account_name) || empty($account_number)
                || empty($depositor_payee) || empty($agent_id) || empty($agency_branch || empty($depositor_payee_phone))
            ) {
                $error          = true;
                $message        = "All fields must be provided";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);

                return;
            } elseif ($total_amount < 1) {
                $error          = true;
                $message        = "All fields must be entered";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);

                return;
            }


            $secure_this_transaction = new CTRLSecureTransaction();

            $to_proceed_with_transaction = null;

            $is_agent_active        = $secure_this_transaction->is_agent_active($this->agency_setup, $agent_id, $agent_key);
            $is_branch_active       = $secure_this_transaction->is_branch_active($this->agency_branches, $agent_id, $agency_branch, $branch_key);
            $is_officer_active      = $secure_this_transaction->is_officer_active($this->abms_users, $agent_id, $officer_id, $user_key);
            $is_transaction_allowed = $secure_this_transaction->is_transaction_allowed($this->geneal_settings);
            $is_transaction_limit_reached = $secure_this_transaction->is_transaction_limit_reached($this->transactions_tbl, $account_number, $account_name, $current_transaction_limit);
            $is_transaction_allowed_for_agent = $secure_this_transaction->is_transaction_allowed_for_agent($this->agency_setup, $agent_key);




            if ($is_agent_active !== 2) {

                $error          = true;
                $message        = "Sorry, Agent is not admitted";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);

                //create activity
                $activities = array(
                    'actions' => 'Transaction Activity. Agent is not admitted',
                    'status' => 'Failed',
                    'usernames' => $officer_id
                );

                $activity_desc = json_encode($activities);

                $activity_data = array(
                    'activity_module' => 'User Login',
                    'activity_desc' => $activity_desc,
                    'user_id' => $officer_id
                );

                $save_activities = $login_obj->userActivitiesMDL($activity_data, $this->table_b);

                return;
            } elseif ($is_branch_active !== 2) {

                $error          = true;
                $message        = "Sorry, Branch is not admitted";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);

                //create activity
                $activities = array(
                    'actions' => 'Transaction Activity. Branch is not admitted',
                    'status' => 'Failed',
                    'usernames' => $officer_id
                );

                $activity_desc = json_encode($activities);

                $activity_data = array(
                    'activity_module' => 'User Login',
                    'activity_desc' => $activity_desc,
                    'user_id' => $officer_id
                );

                $save_activities = $login_obj->userActivitiesMDL($activity_data, $this->table_b);

                return;
            } elseif ($is_officer_active !== 2) {

                $error          = true;
                $message        = "Sorry, Officer is not admitted";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);

                //create activity
                $activities = array(
                    'actions' => 'Transaction Activity. Officer is not admitted',
                    'status' => 'Failed',
                    'usernames' => $officer_id
                );

                $activity_desc = json_encode($activities);

                $activity_data = array(
                    'activity_module' => 'User Login',
                    'activity_desc' => $activity_desc,
                    'user_id' => $officer_id
                );

                $save_activities = $login_obj->userActivitiesMDL($activity_data, $this->table_b);


                return;
            } elseif ($is_transaction_allowed !== 0) {

                $error          = true;
                $message        = "Sorry, transaction is not admitted now";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);

                //create activity
                $activities = array(
                    'actions' => 'Transaction Activity. Transaction is not admitted',
                    'status' => 'Failed',
                    'usernames' => $officer_id
                );

                $activity_desc = json_encode($activities);

                $activity_data = array(
                    'activity_module' => 'User Login',
                    'activity_desc' => $activity_desc,
                    'user_id' => $officer_id
                );

                $save_activities = $login_obj->userActivitiesMDL($activity_data, $this->table_b);


                return;
            } elseif ($is_transaction_limit_reached !== 0) {

                $error          = true;
                $message        = "Sorry, transaction amount is not admitted";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);

                //create activity
                $activities = array(
                    'actions' => 'Transaction Activity. Transaction Amount is not admitted',
                    'status' => 'Failed',
                    'usernames' => $officer_id
                );

                $activity_desc = json_encode($activities);

                $activity_data = array(
                    'activity_module' => 'User Login',
                    'activity_desc' => $activity_desc,
                    'user_id' => $officer_id
                );

                $save_activities = $login_obj->userActivitiesMDL($activity_data, $this->table_b);


                return;
            } elseif ($is_transaction_allowed_for_agent !== 1) {

                $error          = true;
                $message        = "Sorry, transaction not allowed for now.";
                $error_code     = 112;

                $response_msg   = array(
                    'error' => true,
                    'message' => $message,
                    'error_code' => $error_code
                );

                echo json_encode($response_msg);

                //create activity
                $activities = array(
                    'actions' => 'Transaction Activity. Transaction revoked for this agent',
                    'status' => 'Failed',
                    'usernames' => $officer_id
                );

                $activity_desc = json_encode($activities);

                $activity_data = array(
                    'activity_module' => 'User Login',
                    'activity_desc' => $activity_desc,
                    'user_id' => $officer_id
                );

                $save_activities = $login_obj->userActivitiesMDL($activity_data, $this->table_b);


                return;
            } elseif ($is_agent_active == 2 && $is_branch_active == 2 && $is_officer_active == 2 && $is_transaction_allowed == 0 && $is_transaction_limit_reached == 0 && !$error) {

                //$to_proceed_with_transaction .= "Yes";
                require_once dirname(__DIR__) . '/model/MDLSaveTransactions.php';
                $saveTransactionObj = new MDLSaveTransactions();
                //proceed to bank save, then bank api
                $data = array(
                    'transaction_type' => $transaction_type,
                    'transaction_category' => $transaction_category,
                    'product_id' => $product_id,
                    'partner_id' => $partner_id,
                    'unit_price' => $unit_price,
                    'total_qty' => $total_qty,
                    'total_amount' => $total_amount,
                    'officer_id' => $officer_id,
                    'narration' => $narration,
                    'id_type' => $id_type,
                    'id_number' => $id_number,
                    'account_name' => $account_name,
                    'account_number' => $account_number,
                    'agency_branch' => $agency_branch,
                    'agent_id' => $agent_id,
                    'depositor_payee' => $depositor_payee,
                    'transaction_key' => $transaction_key,
                    'depositor_payee_phone' => $depositor_payee_phone,
                    'transaction_reference' => $transaction_reference,
                    'activity_module' => $activity_module,
                    'activity_desc' => $activity_desc,
                    'notification_desc' => $notification_desc,
                    'notification_type' => $notification_type,
                    'send_to' => $send_to
                );

                if ($saveTransactionObj($data, $this->table_a, $this->table_b, $this->table_c)) {

                    //send request to core banking api





                    //if core api is successful, save in transaction journal





                    //else save in transaction suspense





                    //create activity
                    $activities = array(
                        'actions' => 'Transaction Activity.',
                        'status' => 'Successful',
                        'usernames' => $officer_id
                    );

                    $activity_desc = json_encode($activities);

                    $activity_data = array(
                        'activity_module' => 'User Login',
                        'activity_desc' => $activity_desc,
                        'user_id' => $officer_id
                    );

                    $save_activities = $login_obj->userActivitiesMDL($activity_data, $this->table_b);
                } else {

                    $error          = true;
                    $message        = "Transaction Failed";
                    $error_code     = 112;

                    $response_msg   = array(
                        'error' => true,
                        'message' => $message,
                        'error_code' => $error_code
                    );

                    echo json_encode($response_msg);
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

            //create activity
            $activities = array(

                'actions' => 'Transaction Activity. Action Not Permitted',
                'status' => 'Failed',
                'usernames' => $officer_id
            );

            $activity_desc = json_encode($activities);

            $activity_data = array(
                'activity_module' => 'User Login',
                'activity_desc' => $activity_desc,
                'user_id' => $officer_id
            );

            $save_activities = $login_obj->userActivitiesMDL($activity_data, $this->table_b);


            return;
        }
    }
}

$callClass = new CTRLSaveTransactions('transactions_tbl', 'user_activities', 'notifications', 'agency_branches', 'agency_setup', 'abms_users', 'geneal_settings');
$callMethod = $callClass->saveTransaction();
