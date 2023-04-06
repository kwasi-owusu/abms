<?php
require_once dirname(__DIR__) . '/model/MDLSaveTransactions.php';
require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';

class CTRLCashInOutTransaction extends MDLSaveTransactions
{
    //tables
    private string $transactions_tbl;
    private string $user_activities;
    private string $notifications;
    private string $agency_branches;
    private string $agency_setup;
    private string $abms_users;
    private string $geneal_settings;
    private string $tip;
    private string $commission;
    private string $dr_cr_safe;
    private string $e_cash_transaction;
    private string $balance_tbl;



    function __construct($transactions_tbl, $user_activities, $notifications, $agency_branches, $agency_setup, $abms_users, $geneal_settings, $tip, $commission, $dr_cr_safe, $e_cash_transaction, $balance_tbl)
    {


        $this->transactions_tbl     = $transactions_tbl;
        $this->user_activities      = $user_activities;
        $this->notifications        = $notifications;
        $this->agency_branches      = $agency_branches;
        $this->agency_setup         = $agency_setup;
        $this->abms_users           = $abms_users;
        $this->geneal_settings      = $geneal_settings;
        $this->tip                  = $tip;
        $this->commission           = $commission;
        $this->dr_cr_safe           = $dr_cr_safe;
        $this->e_cash_transaction   = $e_cash_transaction;
        $this->balance_tbl          = $balance_tbl;
    }

    public function save_cash_in_cash_out_transaction($data_b)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfMDLSaveTransactions = new MDLSaveTransactions($newPDO, $thisPDO);

        try {

            $thisPDO->beginTransaction();

            //save transaction information
            $rsp_st = $instanceOfMDLSaveTransactions->saveTransactionMDL($data_b, $this->transactions_tbl);

            // create activity log
            //$create_activity_log = $instanceOfMDLSaveTransactions->create_activity_log($data_b, $this->user_activities);

            //create a tip record
            $rsp_ct = $instanceOfMDLSaveTransactions->create_tip_log($data_b, $this->tip);

            $transaction_type = $data_b['trans_type'];

            if ($transaction_type == 'cr') {
                //debit agent to credit customer account
                $instanceOfMDLSaveTransactions->debit_agent_branch($data_b, $this->balance_tbl);
            }

            //credit agent after debiting customer account
            // else if ($transaction_type == 'dr') {

            //     $instanceOfMDLSaveTransactions->credit_agent_branch($data_b, $this->balance_tbl);
            // }

            $thisPDO->commit();

            return $rsp_st;
        } catch (PDOException $e) {

            $thisPDO->rollback();

            echo "Failed";
        }
    }

    public function update_status_after_transaction($data_b, $transaction_status, $external_transaction_id, $get_transaction_response_code)
    {
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $instanceOfMDLSaveTransactions = new MDLSaveTransactions($newPDO, $thisPDO);

        try {

            $thisPDO->beginTransaction();

            //save transaction information
            $rsp_st     = $instanceOfMDLSaveTransactions->update_transaction_status($data_b, $this->transactions_tbl, $transaction_status, $external_transaction_id);

            $rsp_stt    = $instanceOfMDLSaveTransactions->update_transaction_status_in_tip_tbl($data_b, $this->tip, $transaction_status);

            // create activity log
            //$create_activity_log = $instanceOfMDLSaveTransactions->create_activity_log($data_b, $this->user_activities);

            //if cr transaction failed, credit the agent balance to reverse the earlier debit
            if($get_transaction_response_code !== '00' && $data_b['trans_type'] == 'cr'){
                $credit_after_failed_cr = $instanceOfMDLSaveTransactions->credit_agent_branch($data_b, $this->balance_tbl);
            }

            //create agent balance
            if($data_b['trans_type'] == 'dr' && $get_transaction_response_code == '00'){
                $crd = $instanceOfMDLSaveTransactions->credit_agent_branch($data_b, $this->balance_tbl);
            }


            $thisPDO->commit();

            return $rsp_st;
        } catch (PDOException $e) {

            $thisPDO->rollback();

            echo "Failed";
        }
    }
}
