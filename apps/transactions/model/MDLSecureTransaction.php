<?php


class MDLSecureTransaction
{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO)
    {

        $this->newPDO       = new ConnectDatabase();
        $this->thisPDO      = $this->newPDO->Connect();
    }


    public function is_agent_active_mdl($table_a, $agent_key)
    {

        try {
            $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a WHERE agency_status = 1 AND agency_key = :agk LIMIT 1");

            $stmt->bindValue(':agk', $agent_key, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Request not admitted";
        }
    }


    public function is_branch_active_mdl($table_a, $agent_id, $branch_id)
    {
        
        try {
            $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a WHERE agency_id = :agd AND branch_id = :brk AND branch_status = 1 LIMIT 1");

            $stmt->bindValue(':agd', $agent_id, PDO::PARAM_INT);
            $stmt->bindValue(':brk', $branch_id, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Request not admitted";
        }
    }


    public function is_officer_active_mdl($table_a, $agent_id, $teller_id)
    {
       
        try {
            $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a WHERE user_institution = :agd AND user_id = :uky AND user_status = 1 LIMIT 1");
            $stmt->bindValue(':agd', $agent_id, PDO::PARAM_INT);
            $stmt->bindValue(':uky', $teller_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Request not admitted";
        }
    }

    public function has_branch_got_enough_balance_mdl($table_a, $agency_id, $branch_id)
    {

        try {
            $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a WHERE user_agency_ID = :agd AND agency_branch = :brn LIMIT 1");
            $stmt->bindValue(':agd', $agency_id, PDO::PARAM_INT);
            $stmt->bindValue(':brn', $branch_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo "Request not admitted";
        }
    }

    public function is_transaction_allowed_mdl($table_a)
    {
       
        try {
            $stmt = $this->thisPDO->prepare("SELECT settings_desc, settings_value FROM $table_a WHERE settings_desc = 'stop_all_transactions' AND settings_value = 0 LIMIT 1");

            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Request not admitted";
        }
    }


    public function is_transaction_allowed_for_this_agent_mdl($table_a, $agent_key)
    {
        
        try {
            $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a WHERE agency_key = :agk AND allow_transaction = 1 LIMIT 1");

            $stmt->bindValue(':agk', $agent_key, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Request not admitted";
        }
    }


    public function is_transaction_limit_reached_mdl($table_a, $account_number, $account_name)
    {
        $dt = Date('Y-m-d');

        try {
            $stmt = $this->thisPDO->prepare("SELECT account_name, account_number, SUM(total_amount) AS total_amount, transaction_status, transaction_date 
            FROM $table_a 
            WHERE account_name = :acn
            AND account_number = :acb
            AND transaction_status = 1
            AND transaction_date = :dt
            ");

            $stmt->bindParam(':acn', $account_name, PDO::PARAM_STR);
            $stmt->bindParam(':acb', $account_number, PDO::PARAM_STR);
            $stmt->bindParam(':dt', $dt, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Request not admitted";
        }
    }


    public function is_this_pos_terminal_authorized($table_a, $agent_id, $pos_dna)
    {

        try {
            $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a WHERE pos_dna = :dn AND agent_id = :ag AND device_status = 1");

            $stmt->bindParam(':dn', $pos_dna, PDO::PARAM_STR);
            $stmt->bindParam(':ag', $agent_id, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Request not admitted";
        }
    }
}
