<?php
!isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/controller/CTRLDashboardSecurity.php'; 
require_once dirname(__DIR__) . '/model/MDLSecureDashboard.php';

class CTRLDashboardSummaries{

    public function dashboard_summary(){

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();


        $officer_id         = $_SESSION['officer_id'];
        $user_access_level  = $_SESSION['user_access_level'];
        $dashboard_sec      = new CTRLDashboardSecurity('agency_setup', 'agency_branches', 'transactions_tbl', 'abms_users', $officer_id, $user_access_level);

        $mds = new MDLSecureDashboard($newPDO, $thisPDO);

        //get total users
        $total_active_users = $dashboard_sec->check_total_active_user($officer_id, $user_access_level, $mds);
        
        //total logged in users
        $check_total_users_logged_in = $dashboard_sec->check_total_users_logged_in($officer_id, $user_access_level, $mds);

        //total active agencies
        $check_total_active_agencies = $dashboard_sec->check_total_active_user($officer_id, $user_access_level, $mds);

        //total active branches
        $check_total_active_branches = $dashboard_sec->check_total_active_user($officer_id, $user_access_level, $mds);
        
        //echo $total_active_users;
        
        $response_msg = array(
            'total_active_users' => $total_active_users,
            'check_total_users_logged_in' => $check_total_users_logged_in,
            'check_total_active_agencies' => $check_total_active_agencies,
            'check_total_active_branches' => $check_total_active_branches,
        );

        $resp =  json_encode($response_msg);

        echo $resp;
        
    }
}

$callaClass = new CTRLDashboardSummaries();
$callMethod = $callaClass->dashboard_summary();