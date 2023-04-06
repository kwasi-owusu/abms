<?php

class MDLSaveTransactions
{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO)
    {

        $this->newPDO       = new ConnectDatabase();
        $this->thisPDO      = $this->newPDO->Connect();
    }


    public function saveTransactionMDL($data_b, $table_a)
    {

        $stmt = $this->thisPDO->prepare("INSERT INTO $table_a(trans_category, trans_type, product_id, total_amount, officer_id, narration, id_type, 
        id_number, account_name, account_number, agency_branch, agency_id, transaction_reference, transaction_key, depositor_payee) 
        VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt->execute(array(
            $data_b['trans_cat'],
            $data_b['trans_type'],
            $data_b['product_id'],
            $data_b['amount'],
            $data_b['teller_id'],
            $data_b['narration'],
            $data_b['id_type'],
            $data_b['id_number'],
            $data_b['account_name'],
            $data_b['account_number'],
            $data_b['branch_id'],
            $data_b['agent_id'],
            $data_b['mobile_transaction_reference'],
            $data_b['transaction_key'],
            $data_b['depositor_payee']

        ))) {
            return true;
        } else {
            return false;
        }
    }

    //create activity log
    public function create_activity_log($data_b, $table_a)
    {
        //save notification
        $stmt = $this->thisPDO->prepare("INSERT INTO $table_a(notification_desc, notification_type, send_to)) VALUES(?, ?, ?)");
        if ($stmt->execute(
            array(
                $data_b['notification_desc'],
                $data_b['notification_type'],
                $data_b['send_to']
            )
        )) {
            return true;
        } else {
            return false;
        }
    }

    //create tip log
    public function create_tip_log($data_b, $table_a)
    {
        $stmt = $this->thisPDO->prepare("INSERT INTO $table_a(transaction_reference, amount)
        VALUES(?, ?)");
        if ($stmt->execute(
            array(
                $data_b['transaction_key'],
                $data_b['amount']
            )
        )) {
            return true;
        } else {
            return false;
        }
    }


    public function debit_agent_branch($data_b, $table_a)
    {
        $stmt = $this->thisPDO->prepare("UPDATE $table_a SET amt = amt - :mt WHERE user_agency_ID = :agd AND agency_branch = :brn");
        $stmt->bindParam('mt', $data_b['amount'], PDO::PARAM_STR);
        $stmt->bindParam('agd', $data_b['agent_id'], PDO::PARAM_STR);
        $stmt->bindParam('brn', $data_b['branch_id'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function credit_agent_branch($data_b, $table_a)
    {
        $stmt = $this->thisPDO->prepare("UPDATE $table_a SET amt = amt + :mt WHERE user_agency_ID = :agd AND agency_branch = :brn");
        $stmt->bindParam('mt', $data_b['amount'], PDO::PARAM_STR);
        $stmt->bindParam('agd', $data_b['agent_id'], PDO::PARAM_STR);
        $stmt->bindParam('brn', $data_b['branch_id'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update_transaction_status($data_b, $table_a, $transaction_status, $external_transaction_id){
        $stmt = $this->thisPDO->prepare("UPDATE $table_a SET transaction_status = :ts, external_transaction_id = :exd WHERE transaction_key = :tk");
        $stmt->bindParam(':ts', $transaction_status, PDO::PARAM_STR);
        $stmt->bindParam(':exd', $external_transaction_id, PDO::PARAM_STR);
        $stmt->bindParam(':tk', $data_b['transaction_key'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function update_transaction_status_in_tip_tbl($data_b, $table_a, $transaction_status){
        $stmt = $this->thisPDO->prepare("UPDATE $table_a SET transaction_status = :ts WHERE transaction_reference = :tr");
        $stmt->bindParam(':ts', $transaction_status, PDO::PARAM_STR);
        $stmt->bindParam(':tr', $data_b['transaction_key'], PDO::PARAM_STR);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
