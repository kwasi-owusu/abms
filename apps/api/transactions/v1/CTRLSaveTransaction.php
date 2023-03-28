<?php

!isset($_SESSION) ? session_start() : null;

date_default_timezone_set("Africa/Accra");

require_once dirname(__DIR__, 3) . '/transactions/controller/CTRLSecureTransaction.php';
require_once dirname(__DIR__, 3) . '/auth/model/MDLUserActivities.php';
require_once dirname(__DIR__, 3) . '/transactions/controller/CTRLCashInOutTransaction.php';



class CTRLSaveTransactions
{



    public function saveTransaction()
    {

        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $data = json_decode(@file_get_contents('php://input'));

        $secure_this_transaction =  new CTRLSecureTransaction('transactions_tbl', 'user_activities', 'notifications', 'agency_branches', 'agency_setup', 'abms_users', 'geneal_settings', 'pos_terminal_registration', 'balance_tbl');

        $is_pos_terminal_authorized = $secure_this_transaction->is_pos_terminal_authorized($data->Agent_Details->agent_id, $data->account_details->pos_dna);

        if (
            !isset($data->Agent_Details->agent_id) || !isset($data->Agent_Details->agent_key) || !isset($data->account_details->pos_dna)
            || !isset($data->Agent_Details->branch_id)
        ) {

            $error = true;
            $error_code = 111;
            $responseMSG = "This Transaction is not admitted";
            $response_data = array(
                'error' => 'true',
                'code' => $error_code,
                'msg' => $responseMSG
            );
            echo json_encode($response_data);

            return;
        }

        $error = false;

        //agent details
        $agent_id      = isset($data->Agent_Details->agent_id) ? trim(strip_tags($data->Agent_Details->agent_id)) : $error = true;
        $agent_key     = isset($data->Agent_Details->agent_key) ? trim(strip_tags($data->Agent_Details->agent_key)) : $error = true;
        $branch_id     = isset($data->Agent_Details->branch_id) ? trim(strip_tags($data->Agent_Details->branch_id)) : $error = true;
        $branch_key    = isset($data->Agent_Details->branch_key) ? trim(strip_tags($data->Agent_Details->branch_key)) : $error = true;


        if ($is_pos_terminal_authorized > 0) {

            require_once dirname(__DIR__, 3) . '/settings/enums/TransactionAccountEnums.php';

            //transaction object
            $trans_cat          = isset($data->transaction->trans_cat) ? trim(strip_tags($data->transaction->trans_cat)) : $error = true;
            $trans_type         = isset($data->transaction->trans_type) ? trim(strip_tags($data->transaction->trans_type)) : $error = true;
            $customer_name      = isset($data->transaction->customer_name) ? trim(strip_tags($data->transaction->customer_name)) : $error = true;
            $id_number          = isset($data->transaction->id_number) ? trim(strip_tags($data->transaction->id_number)) : $error = true;
            $id_type            = isset($data->transaction->id_type) ? trim(strip_tags($data->transaction->id_type)) : $error = true;
            $amount             = isset($data->transaction->amount) ? trim(strip_tags($data->transaction->amount)) : $error = true;
            $narration          = isset($data->transaction->narration) ? trim(strip_tags($data->transaction->narration)) : null;
            $depositor_payee    = isset($data->transaction->depositor_payee) ? trim(strip_tags($data->transaction->depositor_payee)) : $error = true;
            $product_id         = isset($data->transaction->product_id) ? trim(strip_tags($data->transaction->product_id)) : $error = true;


            //account details
            $account_number     = isset($data->account_details->account_number) ? trim(strip_tags($data->account_details->account_number)) : $error = true;
            $account_name       = isset($data->account_details->account_name) ? trim(strip_tags($data->account_details->account_name)) : $error = true;
            $card_expiry_date   = !isset($data->account_details->card_expiry_date) && $trans_type == 'cash-out' ? $error = true : $error = false;
            $cvv                = !isset($data->account_details->cvv) && $trans_type == 'cash-out' ? $error = true : $error = false;


            $transaction_hash_key       = TransactionHashKeys::save_transaction->value;
            $account_name_hashed        = hash_hmac('sha512', trim(strip_tags($account_name)),  $transaction_hash_key);
            $account_number_hashed      = hash_hmac('sha512', trim(strip_tags($account_number)),  $transaction_hash_key);

            //teller details
            $teller_id         = isset($data->teller_details->teller_id) ? trim(strip_tags($data->teller_details->teller_id)) : $error = true;
            $teller_name       = isset($data->teller_details->teller_name) ? trim(strip_tags($data->teller_details->teller_name)) : $error = true;

            //meta details
            $transaction_date       = isset($data->meta_data->transaction_date) ? trim(strip_tags($data->meta_data->transaction_date)) : $error = true;
            $mobile_transaction_reference  = isset($data->meta_data->mobile_transaction_reference) ? trim(strip_tags($data->meta_data->mobile_transaction_reference)) : $error = true;
            
            $is_agent_active                    = $secure_this_transaction->is_agent_active($agent_key);
            $is_branch_active                   = $secure_this_transaction->is_branch_active($agent_id, $branch_id);
            $is_officer_active                  = $secure_this_transaction->is_officer_active($agent_id, $teller_id);


            if ($is_agent_active == 1 && $is_branch_active == 1 && $is_officer_active == 1) {

                $activity_module            = "Transaction";
                $activity_desc              = "New Transaction Saved";

                
                $notification_desc          = "A $trans_type transaction has occurred on your account";
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

                $toHashThis                 = $account_name . $account_name . $amount;
                $transaction_key            = hash_hmac('sha512', $toHashThis, $transaction_reference);

                //check transaction type
                if ($trans_type  == 'cr') {

                    //check branch balance
                    $has_branch_got_enough_balance      = $secure_this_transaction->has_branch_got_enough_balance($agent_id, $branch_id);
                    $fetch_branch_balance = $has_branch_got_enough_balance->fetch(PDO::FETCH_ASSOC);
                    $branch_bal = $fetch_branch_balance['amt'];

                    if ($amount > $branch_bal) {

                        $error          = true;
                        $message        = "Transaction not admitted";
                        $error_code     = 112;

                        $response_msg   = array(
                            'error' => true,
                            'message' => $message,
                            'error_code' => $error_code
                        );

                        echo json_encode($response_msg);

                        //create activity
                       

                        return;
                    }
                }

                //check if transaction is allowed;
                $is_transaction_allowed             = $secure_this_transaction->is_transaction_allowed();
                $is_transaction_allowed_for_agent   = $secure_this_transaction->is_transaction_allowed_for_agent($agent_key);

                if ($is_transaction_allowed == 1 && $is_transaction_allowed_for_agent == 1 && !$error) {

                    //post transaction
                    $data_b = array(
                        'trans_cat' => $trans_cat,
                        'trans_type' => $trans_type,
                        'customer_name' => $customer_name,
                        'id_number' => $id_number,
                        'id_type' => $id_type,
                        'narration' => $narration,
                        'depositor_payee' => $depositor_payee,
                        'product_id' => $product_id,
                        'account_number' => $account_number,
                        'account_name' => $account_name,
                        'card_expiry_date' => $card_expiry_date,
                        'cvv' => $cvv,
                        'account_name_hashed' => $account_name_hashed,
                        'account_number_hashed' => $account_number_hashed,
                        'teller_id' => $teller_id,
                        'teller_name' => $teller_name,
                        'transaction_date' => $transaction_date,
                        'mobile_transaction_reference' => $mobile_transaction_reference,
                        'branch_id' => $branch_id,
                        'agent_id' => $agent_id,
                        'transaction_key' => $transaction_key,
                        'amount' => $amount,
                    );

                    $newPDO = new ConnectDatabase();
                    $thisPDO = $newPDO->Connect();

                    $instanceOfCTRLCashInOutTransaction = new CTRLCashInOutTransaction('transactions_tbl', 'user_activities', 'notifications', 'agency_branches', 'agency_setup', 'abms_users', 'geneal_settings', 'tip', 'commission', 'dr_cr_safe', 'e_cash_transaction', 'balance_tbl', $newPDO, $thisPDO);
                    //$this->transactions_tbl
                    
                    if ($instanceOfCTRLCashInOutTransaction->save_cash_in_cash_out_transaction($data_b)) {

                        echo "Successfully";

                        //push to peoples pay

                    }
                }
            }
            
        } else {
            $error          = true;
            $message        = "Action not permitted 1";
            $error_code     = 112;

            $response_msg   = array(
                'error' => true,
                'message' => $message,
                'error_code' => $error_code
            );

            echo json_encode($response_msg);

            //create activity
            $activities = array(

                'actions' => 'Transaction Activity. Action Not Permitted 2',
                'status' => 'Failed',
                'usernames' => $teller_id
            );

            $activity_desc = json_encode($activities);

            $activity_data = array(
                'activity_module' => 'User Login',
                'activity_desc' => $activity_desc,
                'user_id' => $teller_id
            );

            $save_activities = $login_obj->userActivitiesMDL($activity_data);

            return;
        }
    }
}

$callClass = new CTRLSaveTransactions();
$callMethod = $callClass->saveTransaction();
