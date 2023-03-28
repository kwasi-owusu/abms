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

        $stmt->execute(array(
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

        ));
    }

    //create activity log
    public function create_activity_log($data_b, $table_a)
    {
        //save notification
        $stmt = $this->thisPDO->prepare("INSERT INTO $table_a(notification_desc, notification_type, send_to)) VALUES(?, ?, ?)");
        $stmt->execute(
            array(
                $data_b['notification_desc'],
                $data_b['notification_type'],
                $data_b['send_to']
            )
        );
    }

    //create tip log
    public function create_tip_log($data_b, $table_a)
    {
        $stmt = $this->thisPDO->prepare("INSERT INTO $table_a(transaction_reference, amount)
        VALUES(?, ?)");
        $stmt->execute(
            array(
                $data_b['transaction_key'],
                $data_b['amount']
            )
        );
    }


    public function debit_agent_branch($data_b, $table_a)
    {
        $stmt = $this->thisPDO->prepare("UPDATE $table_a SET amt = amt - :mt WHERE user_agency_ID = :agd AND agency_branch = :brn");
        $stmt->bindParam('mt', $data_b['amount'], PDO::PARAM_STR);
        $stmt->bindParam('agd', $data_b['agent_id'], PDO::PARAM_STR);
        $stmt->bindParam('brn', $data_b['branch_id'], PDO::PARAM_STR);
        $stmt->execute();
    }

    public function credit_agent_branch($data_b, $table_a)
    {
        $stmt = $this->thisPDO->prepare("UPDATE $table_a SET amt = amt + :mt WHERE user_agency_ID = :agd AND agency_branch = :brn");
        $stmt->bindParam('mt', $data_b['amount'], PDO::PARAM_STR);
        $stmt->bindParam('agd', $data_b['agent_id'], PDO::PARAM_STR);
        $stmt->bindParam('brn', $data_b['branch_id'], PDO::PARAM_STR);
        $stmt->execute();
    }
}
