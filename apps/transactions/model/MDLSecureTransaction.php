<?php
require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';

class MDLSecureTransaction extends ConnectDatabase
{


    public function is_agent_active_mdl($sec_table_a, $agent_id, $agent_key)
    {
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        try {
            $stmt = $thisPDO->prepare("SELECT * FROM $sec_table_a 
            WHERE agency_id = :agd 
            AND agency_status = 1 
            AND agency_key = :agk
            LIMIT 1");

            $stmt->bindValue(':agd', $agent_id, PDO::PARAM_INT);
            $stmt->bindValue(':agk', $agent_key, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo "Request not admitted";
        }
    }
    

    public function is_branch_active_mdl($table_d, $agent_id, $agency_branch, $branch_key)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        try {
            $stmt = $thisPDO->prepare("SELECT * FROM $table_d 
            WHERE branch_id = :brd 
            AND agency_id = :agd 
            AND branch_status = 1 
            AND branch_key = : brk
            LIMIT 1");

            $stmt->bindValue(':brd', $agency_branch, PDO::PARAM_INT);
            $stmt->bindValue(':agd', $agent_id, PDO::PARAM_INT);
            $stmt->bindValue(':brk', $branch_key, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo "Request not admitted";
        }
    }


    public function is_officer_active_mdl($sec_table_c, $agent_id, $officer_id, $user_key)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        try {
            $stmt = $thisPDO->prepare("SELECT * FROM $sec_table_c 
            WHERE user_id = :off 
            AND agency_id = :agd 
            AND user_key = :uky 
            LIMIT 1");
            $stmt->bindValue(':off', $officer_id, PDO::PARAM_INT);
            $stmt->bindValue(':agd', $agent_id, PDO::PARAM_INT);
            $stmt->bindValue(':uky', $user_key, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo "Request not admitted";
        }
    }

    public function is_transaction_allowed_mdl($sec_table_d)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        try {
            $stmt = $thisPDO->prepare("SELECT settings_desc, settings_value FROM $sec_table_d 
            WHERE settings_desc = lock_transactions_now
            LIMIT 1");

            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Request not admitted";
        }
    }


    public function is_transaction_allowed_for_this_agent_mdl($agent_setup_tbl, $agent_key)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        try {
            $stmt = $thisPDO->prepare("SELECT * FROM $agent_setup_tbl 
            WHERE agency_key = agk
            LIMIT 1");

            $stmt->bindValue(':agk', $agent_key, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Request not admitted";
        }
    }


    public function is_transaction_limit_reached_mdl($table_a, $account_number, $account_name)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $dt = Date('Y-m-d');

        try {
            $stmt = $thisPDO->prepare("SELECT account_name, account_numbers, SUM(total_amount) AS total_amount, transaction_status, transaction_date 
            FROM $table_a 
            WHERE account_name = :acn
            AND account_numbers = :acb
            AND transaction_status = 'successful'
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
}
