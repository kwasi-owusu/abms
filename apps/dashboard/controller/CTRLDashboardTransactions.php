<?php

!isset($_SESSION) ? session_start() : null;
require_once dirname(__DIR__) . '/controller/CTRLDashboardSecurity.php'; 
require_once dirname(__DIR__) . '/model/MDLSecureDashboard.php';

class CTRLDashboardTransactions{

    public function dashboard_transaction_summaries(){

        $officer_id         = $_SESSION['officer_id'];
        $user_access_level  = $_SESSION['user_access_level'];
        $dashboard_sec      = new CTRLDashboardSecurity('agency_setup', 'agency_branches', 'transactions_tbl', 'abms_users', $officer_id, $user_access_level);

        $mds = new MDLSecureDashboard();

        $total_number_of_transactions       = $dashboard_sec->fetch_total_number_of_transactions_for_today($officer_id, $user_access_level, $mds);
        $total_successful_transactions      = $dashboard_sec->fetch_total_successful_transactions_for_today($officer_id, $user_access_level, $mds);
        $total_dr_transactions_for_today    = $dashboard_sec->fetch_total_dr_transactions_for_today($officer_id, $user_access_level, $mds);
        $total_cr_transactions_for_today    = $dashboard_sec->fetch_total_cr_transactions_for_today($officer_id, $user_access_level, $mds);
        $total_sum_dr_for_today             = $dashboard_sec->fetch_sum_total_dr_transactions_for_today($officer_id, $user_access_level, $mds);
        $total_sum_cr_for_today             = $dashboard_sec->fetch_sum_total_cr_transactions_for_today($officer_id, $user_access_level, $mds);

        $totalDebitSum = isset($total_sum_dr_for_today['totalDebitSum']) ? number_format($total_sum_dr_for_today['totalDebitSum'], 2) : number_format(0, 2);
        $totalCreditSum = isset($total_sum_cr_for_today['totalCreditSum']) ? number_format($total_sum_cr_for_today['totalCreditSum'], 2): number_format(0, 2);
        $response_msg = array(
            'total_number_of_transactions' => $total_number_of_transactions,
            'total_successful_transactions' => $total_successful_transactions,
            'total_dr_transactions_for_today' => $total_dr_transactions_for_today,
            'total_cr_transactions_for_today' => $total_cr_transactions_for_today,
            'total_sum_dr_for_today' => $totalDebitSum,
            'total_sum_cr_for_today' => $totalCreditSum
        );

        echo json_encode($response_msg);
    }
}

$callClass = new CTRLDashboardTransactions();
$callMethod = $callClass->dashboard_transaction_summaries();