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
            $issuer_id          = isset($data->account_details->issuer_id) ? trim(strip_tags($data->account_details->issuer_id)) : null;
            $account_type       = isset($data->account_details->account_type) ? trim(strip_tags($data->account_details->account_type)) : null;


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
                    // require bank issuer id
                    if ($issuer_id == null && $account_type !== "bank") {
                        $error          = true;
                        $message        = "Bank Issuer not Identified";
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

                    if ($instanceOfCTRLCashInOutTransaction->save_cash_in_cash_out_transaction($data_b)) {

                        //make a call to peoplespay 

                        $operation = '';
                        if ($trans_type == "cr") {
                            $operation .= 'CREDIT';
                        } else if ($trans_type == "dr") {
                            $operation .= 'DEBIT';
                        }


                        $get_token_data = array(
                            "merchantId" => "63b59e41530aeeaec59a045f",
                            "apikey" => "93064247-4668-4c73-ac43-4dcc28773a86",
                            "operation" => $operation
                        );


                        // convert the PHP array to JSON format
                        $get_token_payload_in_json = json_encode($get_token_data);

                        // create & initialize a curl session 
                        $crl = curl_init();
                        // set our url with curl_setopt() 
                        curl_setopt($crl, CURLOPT_URL, "https://peoplespay.com.gh/peoplepay/hub/token/get");

                        curl_setopt($crl, CURLOPT_POST, true);
                        curl_setopt($crl, CURLOPT_POSTFIELDS, $get_token_payload_in_json);
                        curl_setopt($crl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

                        curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, false);
                        curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

                        $token_response = curl_exec($crl);

                        curl_close($crl);

                        if ($token_response === false) {
                            echo 'Error: ' . curl_error($crl);
                        } else {

                            //decode and convert response to array
                            $token_response_to_array = json_decode($token_response);

                            $get_token = $token_response_to_array->data;

                            //echo $token_response_to_array->data;

                            if (isset($get_token)) {

                                //make request to peoplesPay 
                                // if transaction is dr, use collection
                                // if transaction is cr, use disbursement

                                $base_ur = "https://peoplespay.com.gh/peoplepay/hub/";
                                $transaction_based_url = "";

                                if ($trans_type  == 'cr' && !$error) {

                                    $transaction_based_url .= "disburse";

                                    $disburse_pmt_payload = array(
                                        "amount" => $amount,
                                        "account_number" => $account_number,
                                        "account_name" => $account_name,
                                        "account_issuer" => $issuer_id,
                                        "account_type" => $account_type,
                                        "description" => $narration,
                                        "externalTransactionId" => $transaction_key
                                    );

                                    $disburse_pmt_payload_in_json = json_encode($disburse_pmt_payload);

                                    $authorization = "Authorization: Bearer " . $get_token;
                                    $full_url = $base_ur . $transaction_based_url;

                                    $crl_b = curl_init();
                                    // set our url with curl_setopt() 
                                    curl_setopt($crl_b, CURLOPT_URL, "https://peoplespay.com.gh/peoplepay/hub/" . $transaction_based_url);

                                    curl_setopt($crl_b, CURLOPT_POST, true);
                                    curl_setopt($crl_b, CURLOPT_POSTFIELDS, $disburse_pmt_payload_in_json);
                                    curl_setopt($crl_b, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
                                    //curl_setopt($crl_b, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                                    curl_setopt($crl_b, CURLOPT_RETURNTRANSFER, true);

                                    curl_setopt($crl_b, CURLOPT_SSL_VERIFYHOST, false);
                                    curl_setopt($crl_b, CURLOPT_SSL_VERIFYPEER, false);

                                    $transaction_response = curl_exec($crl_b);

                                    $transaction_response_to_array = json_decode($transaction_response);

                                    $get_transaction_response_code = $transaction_response_to_array->code;
                                    $external_transaction_id = $transaction_response_to_array->transactionId;

                                    $transaction_status = '';

                                    if ($get_transaction_response_code == "00") {

                                        // transaction was successful
                                        $transaction_status .= "1";
                                        if ($instanceOfCTRLCashInOutTransaction->update_status_after_transaction($data_b, $transaction_status, $external_transaction_id, $get_transaction_response_code)) {

                                            $message        = "Transaction Success";
                                            $error_code     = 111;
                                            $paid_status    = "00";
                                            $response_msg   = array(
                                                'error' => false,
                                                'message' => $message,
                                                'error_code' => $error_code,
                                                'paid_status' => $paid_status,
                                                'external_transaction_id' => $external_transaction_id
                                            );

                                            echo json_encode($response_msg);

                                            //create activity

                                            return;
                                        }
                                    } else if ($get_transaction_response_code !== "00") {

                                        // transaction failed. credit merchant accounts
                                        $transaction_status .= "2";
                                        if ($instanceOfCTRLCashInOutTransaction->update_status_after_transaction($data_b, $transaction_status, $external_transaction_id, $get_transaction_response_code)) {
                                            echo "Transaction Failed";

                                            $error          = true;
                                            $message        = "Transaction Failed";
                                            $error_code     = 112;
                                            $paid_status    = 01;
                                            $response_msg   = array(
                                                'error' => true,
                                                'message' => $message,
                                                'error_code' => $error_code,
                                                'paid_status' => $paid_status
                                            );

                                            echo json_encode($response_msg);

                                            //create activity

                                            return;
                                        }
                                    }

                                    curl_close($crl_b);
                                } else if ($trans_type  == 'dr'  && !$error) {
                                    $dr_transaction_based_url .= "collectmoney/card";

                                    $collect_money_payload = array(
                                        "amount" => $amount,
                                        "description" => $narration,
                                        "account_name" => $account_name,
                                        "card" => array(
                                            "cvc" => $cvv,
                                            "expiry" => $card_expiry_date,
                                            "number" => $account_number
                                        ),
                                        "description" => $narration,
                                        "callbackUrl" => "",
                                        "clientRedirectUrl" => ""
                                    );

                                    $collect_money_payload_in_json = json_encode($collect_money_payload);

                                    $dr_authorization   = "Authorization: Bearer " . $get_token;

                                    $crl_c = curl_init();
                                    // set our url with curl_setopt() 
                                    curl_setopt($crl_c, CURLOPT_URL, "https://peoplespay.com.gh/peoplepay/hub/" . $dr_transaction_based_url);

                                    curl_setopt($crl_c, CURLOPT_POST, true);
                                    curl_setopt($crl_c, CURLOPT_POSTFIELDS, $collect_money_payload_in_json);
                                    curl_setopt($crl_c, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $dr_authorization));

                                    curl_setopt($crl_c, CURLOPT_RETURNTRANSFER, true);

                                    curl_setopt($crl_c, CURLOPT_SSL_VERIFYHOST, false);
                                    curl_setopt($crl_c, CURLOPT_SSL_VERIFYPEER, false);

                                    $dr_transaction_response = curl_exec($crl_c);

                                    $dr_transaction_response_to_array = json_decode($dr_transaction_response);

                                    $get_transaction_response_code = $dr_transaction_response_to_array->code;
                                    $dr_external_transaction_id = $dr_transaction_response_to_array->transactionId;

                                    $dr_transaction_status = '';

                                    if ($get_transaction_response_code == "00") {

                                        // transaction was successful
                                        $dr_transaction_status .= "1";
                                        if ($instanceOfCTRLCashInOutTransaction->update_status_after_transaction($data_b, $dr_transaction_status, $dr_external_transaction_id, $get_transaction_response_code)) {

                                            // credit agency account for a dr transaction 


                                            $message        = "Transaction Success";
                                            $error_code     = 111;
                                            $paid_status    = "00";
                                            $response_msg   = array(
                                                'error' => false,
                                                'message' => $message,
                                                'error_code' => $error_code,
                                                'paid_status' => $paid_status,
                                                'external_transaction_id' => $dr_external_transaction_id
                                            );

                                            echo json_encode($response_msg);

                                            //create activity

                                            return;
                                        }
                                    } else if ($get_transaction_response_code !== 00) {

                                        // transaction failed. credit merchant accounts
                                        $transaction_status .= "2";
                                        if ($instanceOfCTRLCashInOutTransaction->update_status_after_transaction($data_b, $transaction_status, $external_transaction_id, $get_transaction_response_code)) {
                                            echo "Transaction Failed";

                                            $error          = true;
                                            $message        = "Transaction Failed";
                                            $error_code     = 112;
                                            $paid_status    = '01';
                                            $response_msg   = array(
                                                'error' => true,
                                                'message' => $message,
                                                'error_code' => $error_code,
                                                'paid_status' => $paid_status
                                            );

                                            echo json_encode($response_msg);

                                            //create activity

                                            return;
                                        }
                                    }
                                }
                            }
                        }


                        // close curl resource to free up system resources and (deletes the variable made by curl_init) 

                    } else {
                        echo "Failed";
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
