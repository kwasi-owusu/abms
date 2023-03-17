<?php
!isset($_SESSION) ? session_start() : null;

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
require_once dirname(__DIR__) . '/controller/CTRLDashboardSecurity.php'; 
require_once dirname(__DIR__) . '/model/MDLSecureDashboard.php';


class CTRLDashboard{
   
    public function transactions_for_today(){

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $officer_id         = $_SESSION['officer_id'];
        $user_access_level  = $_SESSION['user_access_level'];

        $officer_id         = $_SESSION['officer_id'];
        $user_access_level  = $_SESSION['user_access_level'];
        $dashboard_sec      = new CTRLDashboardSecurity('agency_setup', 'agency_branches', 'transactions_tbl', 'abms_users', $officer_id, $user_access_level);

        $mds = new MDLSecureDashboard($newPDO, $thisPDO);

        $transactions_for_today = $dashboard_sec->fetch_transactions_for_today($officer_id, $user_access_level, $mds);

        return $transactions_for_today;
    }
}
