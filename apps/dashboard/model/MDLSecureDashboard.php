<?php

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';

class MDLSecureDashboard extends ConnectDatabase
{

    public function check_total_users_logged_in_mdl($table_a, $officer_id, $user_access_level)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        if ($user_access_level <> 1) {

            if ($user_access_level == 2) {
                $stmt = $thisPDO->prepare("SELECT * FROM $table_a 
            WHERE user_institution = :ins
            AND user_branch = :brn
            AND online_offline = 1
            ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':brn', $_SESSION['user_branch'], PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->rowCount();
            } elseif ($user_access_level == 3) {
                $stmt = $thisPDO->prepare("SELECT * FROM $table_a 
            WHERE user_institution = :ins
            AND online_offline = 1
            ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->rowCount();
            } else {
                $stmt = $thisPDO->prepare("SELECT * FROM $table_a 
            WHERE online_offline = 1
            ");

                $stmt->execute();

                return $stmt->rowCount();
            }
        }
    }

    public function check_total_active_user_mdl($table_a, $officer_id, $user_access_level)
    {
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        if ($user_access_level <> 1) {

            if ($user_access_level == 2) {
                $stmt = $thisPDO->prepare("SELECT * FROM $table_a 
            WHERE user_institution = :ins 
            AND  user_branch = :brn
            AND user_status = 1
            ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':brn', $_SESSION['user_branch'], PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->rowCount();
            } elseif ($user_access_level == 3) {
                $stmt = $thisPDO->prepare("SELECT * FROM $table_a 
                WHERE $table_a.user_institution = :ins 
                AND user_status = 1
                ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->rowCount();
            } else {
                $stmt = $thisPDO->prepare("SELECT * FROM $table_a 
                WHERE user_status = 1
                ");

                $stmt->execute();

                return $stmt->rowCount();
            }
        }
    }


    public function check_total_active_agencies_mdl($table, $officer_id, $user_access_level)
    {
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        if ($user_access_level <> 1) {
            if ($user_access_level == 2 || $user_access_level == 3) {
                $stmt = $thisPDO->prepare("SELECT * FROM $table  
                WHERE agency_id = :ins
                AND agency_status = 1
                ");
                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->rowCount();
            } else {
                $stmt = $thisPDO->prepare("SELECT * FROM $table  
                WHERE AND agency_status = 1
                ");
                $stmt->execute();

                return $stmt->rowCount();
            }
        }
    }


    public function check_total_active_branches_mdl($table, $officer_id, $user_access_level)
    {
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        if ($user_access_level <> 1) {
            if ($user_access_level == 2) {
                $stmt = $thisPDO->prepare("SELECT * FROM $table 
            WHERE agency_id = :ins
            AND branch_id = :brn
            AND branch_status = 1
            ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':brn', $_SESSION['user_branch'], PDO::PARAM_STR);

                $stmt->execute();

                return $stmt->rowCount();
            } elseif ($user_access_level == 3) {
                $stmt = $thisPDO->prepare("SELECT * FROM $table 
                WHERE agency_id = :ins
                AND branch_status = 1
                ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);

                $stmt->execute();

                return $stmt->rowCount();
            } else {
                $stmt = $thisPDO->prepare("SELECT * FROM $table 
                WHERE branch_status = 1
                ");
                $stmt->execute();

                return $stmt->rowCount();
            }
        }
    }


    public function fetch_transactions_for_today_mdl($table_b, $table_c, $table_d, $table_a, $officer_id, $user_access_level)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();
        $tdy = DATE('Y-m-d');

        if ($user_access_level <> 1) {
            if ($user_access_level == 2) {
                $stmt = $thisPDO->prepare("SELECT $table_d.*, $table_b.*, $table_c.*, $table_a.*,
                
                CASE WHEN $table_d.transaction_status = 0 THEN 'Pending'
                WHEN $table_d.transaction_status = 1 THEN 'Successful'
                ELSE 'Unknown'
                END AS TransactionStatus,

                CASE WHEN $table_d.trans_type = 1 THEN 'Deposit'
                WHEN $table_d.trans_type = 2 THEN 'Withdrawal'
                WHEN $table_d.trans_type = 3 THEN 'Third Party Deposit'
                WHEN $table_d.trans_type = 4 THEN 'Transfer'
                ELSE 'Unknown'
                END AS TransactionType
                
                 FROM $table_d
                INNER JOIN $table_b ON $table_d.agency_id = $table_b.agency_id
                INNER JOIN $table_c ON $table_d.agency_branch = $table_c.branch_id
                INNER JOIN $table_a ON $table_d.officer_id = $table_a.user_id

                (CASE WHEN table_d.transaction_status = '0' THEN 'Pending' END) AS 'Pending',
                (CASE WHEN table_d.transaction_status = '1' THEN 'Successful' END) AS 'Successful'

                WHERE $table_d.agency_id = :ins
                AND $table_d.agency_branch = :brn
                AND DATE($table_d.transaction_date) = :tdy
            ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':brn', $_SESSION['user_branch'], PDO::PARAM_STR);
                $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetchAll();
            } elseif ($user_access_level == 3) {
                $stmt = $thisPDO->prepare("SELECT $table_d.*, $table_b.*, $table_c.*, $table_a.*, 
                
                CASE WHEN $table_d.transaction_status = 0 THEN 'Pending'
                WHEN $table_d.transaction_status = 1 THEN 'Successful'
                ELSE 'Unknown'
                END AS TransactionStatus,

                CASE WHEN $table_d.trans_type = 1 THEN 'Deposit'
                WHEN $table_d.trans_type = 2 THEN 'Withdrawal'
                WHEN $table_d.trans_type = 3 THEN 'Third Party Deposit'
                WHEN $table_d.trans_type = 4 THEN 'Transfer'
                ELSE 'Unknown'
                END AS TransactionType

                FROM $table_d

                INNER JOIN $table_b ON $table_d.agency_id = $table_b.agency_id
                INNER JOIN $table_c ON $table_d.agency_branch = $table_c.branch_id
                INNER JOIN $table_a ON $table_d.officer_id = $table_a.user_id
                
                WHERE $table_d.agency_id = :ins
                AND DATE($table_d.transaction_date) = :tdy
            ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetchAll();
            } else {
                $stmt = $thisPDO->prepare("SELECT $table_d.*, $table_b.*, $table_c.*, $table_a.*,
                
                CASE WHEN $table_d.transaction_status = 0 THEN 'Pending'
                WHEN $table_d.transaction_status = 1 THEN 'Successful'
                ELSE 'Unknown'
                END AS TransactionStatus,

                CASE WHEN $table_d.trans_type = 1 THEN 'Deposit'
                WHEN $table_d.trans_type = 2 THEN 'Withdrawal'
                WHEN $table_d.trans_type = 3 THEN 'Third Party Deposit'
                WHEN $table_d.trans_type = 4 THEN 'Transfer'
                ELSE 'Unknown'
                END AS TransactionType
                
                FROM $table_d
                INNER JOIN $table_b ON $table_d.agency_id = $table_b.agency_id
                INNER JOIN $table_c ON $table_d.agency_branch = $table_c.branch_id
                INNER JOIN $table_a ON $table_d.officer_id = $table_a.user_id

                (CASE WHEN table_d.transaction_status = 0 THEN 'Pending' END) AS 'Pending',
                (CASE WHEN table_d.transaction_status = 1 THEN 'Successful' END) AS 'Successful'
                
                WHERE DATE($table_d.transaction_date) = :tdy
            ");

                $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);
                $stmt->execute();

                return $stmt->fetchAll();
            }
        }
    }

    public function fetch_total_number_of_transactions_for_today_mdl($table_b, $table_c, $table_d, $table_a, $officer_id, $user_access_level)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();
        $tdy = DATE('Y-m-d');

        if ($user_access_level <> 1) {
            if ($user_access_level == 2) {
                $stmt = $thisPDO->prepare("SELECT * FROM $table_d 
                WHERE $table_d.agency_id = :ins
                AND $table_d.agency_branch = :brn
                AND DATE($table_d.transaction_date) = :tdy
                ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':brn', $_SESSION['user_branch'], PDO::PARAM_STR);
                $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                $stmt->execute();
                return $stmt->rowCount();
            } elseif ($user_access_level == 3) {
                $stmt = $thisPDO->prepare("SELECT * FROM $table_d 
                WHERE $table_d.agency_id = :ins
                AND DATE($table_d.transaction_date) = :tdy
                ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                $stmt->execute();
                return $stmt->rowCount();
            } else {
                if ($user_access_level == 2) {
                    $stmt = $thisPDO->prepare("SELECT * FROM $table_d 
                    WHERE DATE($table_d.transaction_date) = :tdy
                    ");
                    $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                    $stmt->execute();
                    return $stmt->rowCount();
                }
            }
        }
    }

    public function fetch_total_successful_transactions_for_today_mdl($table_b, $table_c, $table_d, $table_a, $officer_id, $user_access_level)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();
        $tdy = DATE('Y-m-d');

        if ($user_access_level <> 1) {
            if ($user_access_level == 2) {
                $stmt = $thisPDO->prepare("SELECT * FROM $table_d 
                WHERE $table_d.agency_id = :ins
                AND $table_d.agency_branch = :brn
                AND $table_d.transaction_status = 1
                AND DATE($table_d.transaction_date) = :tdy
                ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':brn', $_SESSION['user_branch'], PDO::PARAM_STR);
                $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                $stmt->execute();
                return $stmt->rowCount();
            } elseif ($user_access_level == 3) {
                $stmt = $thisPDO->prepare("SELECT * FROM $table_d 
                WHERE $table_d.agency_id = :ins
                AND $table_d.transaction_status = 1
                AND DATE($table_d.transaction_date) = :tdy
                ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                $stmt->execute();
                return $stmt->rowCount();
            } else {
                if ($user_access_level == 2) {
                    $stmt = $thisPDO->prepare("SELECT * FROM $table_d 
                    WHERE DATE($table_d.transaction_date) = :tdy
                    AND $table_d.transaction_status = 1
                    ");
                    $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                    $stmt->execute();
                    return $stmt->rowCount();
                }
            }
        }
    }

    public function fetch_total_dr_transactions_for_today_mdl($table_b, $table_c, $table_d, $table_a, $officer_id, $user_access_level)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();
        $tdy = DATE('Y-m-d');

        if ($user_access_level <> 1) {
            if ($user_access_level == 2) {
                $stmt = $thisPDO->prepare("SELECT * FROM $table_d 
                WHERE $table_d.agency_id = :ins
                AND $table_d.agency_branch = :brn
                AND $table_d.trans_type = 2
                AND $table_d.transaction_status = 1
                AND DATE($table_d.transaction_date) = :tdy
                ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':brn', $_SESSION['user_branch'], PDO::PARAM_STR);
                $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                $stmt->execute();
                return $stmt->rowCount();
            } elseif ($user_access_level == 3) {
                $stmt = $thisPDO->prepare("SELECT * FROM $table_d 
                WHERE $table_d.agency_id = :ins
                AND $table_d.trans_type = 2
                AND $table_d.transaction_status = 1
                AND DATE($table_d.transaction_date) = :tdy
                ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                $stmt->execute();
                return $stmt->rowCount();
            } else {
                if ($user_access_level == 2) {
                    $stmt = $thisPDO->prepare("SELECT * FROM $table_d 
                    WHERE DATE($table_d.transaction_date) = :tdy
                    AND $table_d.trans_type = 2
                    AND $table_d.transaction_status = 1
                    AND DATE($table_d.transaction_date) = :tdy
                    ");
                    $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                    $stmt->execute();
                    return $stmt->rowCount();
                }
            }
        }
    }

    public function fetch_total_cr_transactions_for_today_mdl($table_b, $table_c, $table_d, $table_a, $officer_id, $user_access_level)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();
        $tdy = DATE('Y-m-d');

        if ($user_access_level <> 1) {
            if ($user_access_level == 2) {
                $stmt = $thisPDO->prepare("SELECT * FROM $table_d 
                WHERE $table_d.agency_id = :ins
                AND $table_d.agency_branch = :brn
                AND $table_d.trans_type = 1
                AND $table_d.transaction_status = 1
                AND DATE($table_d.transaction_date) = :tdy
                ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':brn', $_SESSION['user_branch'], PDO::PARAM_STR);
                $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                $stmt->execute();
                return $stmt->rowCount();
            } elseif ($user_access_level == 3) {
                $stmt = $thisPDO->prepare("SELECT * FROM $table_d 
                WHERE $table_d.agency_id = :ins
                AND $table_d.trans_type = 1
                AND $table_d.transaction_status = 1
                AND DATE($table_d.transaction_date) = :tdy
                ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                $stmt->execute();
                return $stmt->rowCount();
            } else {
                if ($user_access_level == 2) {
                    $stmt = $thisPDO->prepare("SELECT * FROM $table_d 
                    WHERE DATE($table_d.transaction_date) = :tdy
                    AND $table_d.trans_type = 1
                    AND $table_d.transaction_status = 1
                    AND DATE($table_d.transaction_date) = :tdy
                    ");
                    $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                    $stmt->execute();
                    return $stmt->rowCount();
                }
            }
        }
    }

    public function fetch_sum_total_dr_transactions_for_today_mdl($table_b, $table_c, $table_d, $table_a, $officer_id, $user_access_level)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();
        $tdy = DATE('Y-m-d');

        if ($user_access_level <> 1) {
            if ($user_access_level == 2) {
                $stmt = $thisPDO->prepare("SELECT total_amount, SUM(total_amount) AS totalDebitSum, agency_id, agency_branch, trans_type, transaction_status, transaction_date FROM $table_d 
                WHERE $table_d.agency_id = :ins
                AND $table_d.agency_branch = :brn
                AND $table_d.trans_type = 2
                AND $table_d.transaction_status = 1
                AND DATE($table_d.transaction_date) = :tdy
                ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':brn', $_SESSION['user_branch'], PDO::PARAM_STR);
                $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } elseif ($user_access_level == 3) {
                $stmt = $thisPDO->prepare("SELECT total_amount, SUM(total_amount) AS totalDebitSum, agency_id, agency_branch, trans_type, transaction_status, transaction_date FROM $table_d 
                WHERE $table_d.agency_id = :ins
                AND $table_d.trans_type = 2
                AND $table_d.transaction_status = 1
                AND DATE($table_d.transaction_date) = :tdy
                ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                if ($user_access_level == 2) {
                    $stmt = $thisPDO->prepare("SELECT total_amount, SUM(total_amount) AS totalDebitSum, agency_id, agency_branch, trans_type, transaction_status, transaction_date FROM $table_d 
                    WHERE DATE($table_d.transaction_date) = :tdy
                    AND $table_d.trans_type = 2
                    AND $table_d.transaction_status = 1
                    AND DATE($table_d.transaction_date) = :tdy
                    ");
                    $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                    $stmt->execute();
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
        }
    }

    public function fetch_sum_total_cr_transactions_for_today_mdl($table_b, $table_c, $table_d, $table_a, $officer_id, $user_access_level)
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();
        $tdy = DATE('Y-m-d');

        if ($user_access_level <> 1) {
            if ($user_access_level == 2) {
                $stmt = $thisPDO->prepare("SELECT total_amount, SUM(total_amount) AS totalCreditSum, agency_id, agency_branch, trans_type, transaction_status, transaction_date FROM $table_d 
                WHERE $table_d.agency_id = :ins
                AND $table_d.agency_branch = :brn
                AND $table_d.trans_type = 1
                AND $table_d.transaction_status = 1
                AND DATE($table_d.transaction_date) = :tdy
                ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':brn', $_SESSION['user_branch'], PDO::PARAM_STR);
                $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } elseif ($user_access_level == 3) {
                $stmt = $thisPDO->prepare("SELECT total_amount, SUM(total_amount) AS totalCreditSum, agency_id, agency_branch, trans_type, transaction_status, transaction_date FROM $table_d 
                WHERE $table_d.agency_id = :ins
                AND $table_d.trans_type = 1
                AND $table_d.transaction_status = 1
                AND DATE($table_d.transaction_date) = :tdy
                ");

                $stmt->bindParam(':ins', $_SESSION['user_institution'], PDO::PARAM_STR);
                $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                if ($user_access_level == 2) {
                    $stmt = $thisPDO->prepare("SELECT total_amount, SUM(total_amount) AS totalCreditSum, agency_id, agency_branch, trans_type, transaction_status, transaction_date FROM $table_d 
                    WHERE DATE($table_d.transaction_date) = :tdy
                    AND $table_d.trans_type = 1
                    AND $table_d.transaction_status = 1
                    AND DATE($table_d.transaction_date) = :tdy
                    ");
                    $stmt->bindParam(':tdy', $tdy, PDO::PARAM_STR);

                    $stmt->execute();
                    return $stmt->fetch(PDO::FETCH_ASSOC);
                }
            }
        }
    }
}
