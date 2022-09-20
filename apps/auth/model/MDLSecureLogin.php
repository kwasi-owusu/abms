<?php
require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';

class MDLSecureLogin extends ConnectDatabase
{

    public function is_branch_still_active_mdl($user_branch, $table)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $stmt = $thisPDO->prepare("SELECT branch_status FROM $table WHERE branch_id = :bd LIMIT 1");
        $stmt->bindValue(':bd', $user_branch, PDO::PARAM_INT);


        $stmt->execute();

        $branch_status = $stmt->fetchColumn();

        $val = isset($branch_status['branch_status']) ? $branch_status['branch_status'] : 0;

        return $val;
    }

    public function is_agency_still_active_mdl($user_institution, $table)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $stmt = $thisPDO->prepare("SELECT agency_status FROM $table WHERE agency_id = :agd LIMIT 1");
        $stmt->bindValue(':agd', $user_institution, PDO::PARAM_INT);

        $stmt->execute();

        $agent_status = $stmt->fetch(PDO::FETCH_ASSOC);

        $val = isset($agent_status['agency_status']) ? $agent_status['agency_status'] : 0;

        return $val;
    }


    public function is_password_valid_mdl($officer_id, $password, $table)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $stmt = $thisPDO->prepare("SELECT * FROM $table WHERE user_id = :uid AND password = :password ORDER BY password_log_id DESC LIMIT 1");
        $stmt->bindValue(':uid', $officer_id, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
