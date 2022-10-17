<?php

require_once dirname(__DIR__) . '/controller/ISecureDashboard.php';
require_once dirname(__DIR__) . '/model/MDLSecureDashboard.php';

class CTRLDashboardSecurity implements ISecureDashboard
{

    private $users_table;
    private $agencies;
    private $branches;
    private $transactions_tbl;
    private $officer_id;
    private $user_access_level;

    public function __construct($agencies, $branches, $transactions_tbl, $users_table, $officer_id, $user_access_level)
    {
        $this->table_a      = $users_table;
        $this->table_b      = $agencies;
        $this->table_c      = $branches;
        $this->table_d      = $transactions_tbl;
        $this->officer_id   = $officer_id;
        $this->user_access_level = $user_access_level;
    }

    public function check_total_active_user(string $officer_id, string $user_access_level, MDLSecureDashboard $mds): int
    {

        $fetch_total_active_users = $mds->check_total_active_user_mdl($this->table_a, $officer_id, $user_access_level);

        return $fetch_total_active_users;
    }

    public function check_total_users_logged_in(string $officer_id, string $user_access_level, MDLSecureDashboard $mds): int
    {

        $fetch_total_online_users = $mds->check_total_users_logged_in_mdl($this->table_a, $officer_id, $user_access_level);

        return $fetch_total_online_users;
    }

    public function check_total_active_agencies(string $officer_id, string $user_access_level, MDLSecureDashboard $mds): int
    {

        $fetch_active_agencies = $mds->check_total_active_agencies_mdl($this->table_b, $officer_id, $user_access_level);

        return $fetch_active_agencies;
    }

    public function check_total_active_branches(string $officer_id, string $user_access_level, MDLSecureDashboard $mds): int
    {

        $fetch_active_branches = $mds->check_total_active_branches_mdl($this->table_c, $officer_id, $user_access_level);

        return $fetch_active_branches;
    }

    public function fetch_transactions_for_today(string $officer_id, string $user_access_level, MDLSecureDashboard $mds): array
    {

        $fetch_active_branches = $mds->fetch_transactions_for_today_mdl($this->table_b, $this->table_c, $this->table_d, $this->table_a, $officer_id, $user_access_level);

        return $fetch_active_branches;
    }


    public function fetch_total_number_of_transactions_for_today(string $officer_id, string $user_access_level, MDLSecureDashboard $mds): int
    {
        $fetch_total_number_of_transactions_today = $mds->fetch_total_number_of_transactions_for_today_mdl($this->table_b, $this->table_c, $this->table_d, $this->table_a, $officer_id, $user_access_level);

        return $fetch_total_number_of_transactions_today;
    }


    public function fetch_total_successful_transactions_for_today(string $officer_id, string $user_access_level, MDLSecureDashboard $mds): int
    {

        $fetch_total_successful_transactions = $mds->fetch_total_successful_transactions_for_today_mdl($this->table_b, $this->table_c, $this->table_d, $this->table_a, $officer_id, $user_access_level);

        return $fetch_total_successful_transactions;
    }

    public function fetch_total_dr_transactions_for_today(string $officer_id, string $user_access_level, MDLSecureDashboard $mds): int
    {

        $fetch_dr_successful_transactions = $mds->fetch_total_dr_transactions_for_today_mdl($this->table_b, $this->table_c, $this->table_d, $this->table_a, $officer_id, $user_access_level);
        return $fetch_dr_successful_transactions;
    }

    
    public function fetch_total_cr_transactions_for_today(string $officer_id, string $user_access_level, MDLSecureDashboard $mds): int
    {
        $fetch_total_cr_transactions_for_today = $mds->fetch_total_cr_transactions_for_today_mdl($this->table_b, $this->table_c, $this->table_d, $this->table_a, $officer_id, $user_access_level);

        return $fetch_total_cr_transactions_for_today;
    }

    public function fetch_sum_total_dr_transactions_for_today(string $officer_id, string $user_access_level, MDLSecureDashboard $mds) : array{

        $fetch_sum_debit = $mds->fetch_sum_total_dr_transactions_for_today_mdl($this->table_b, $this->table_c, $this->table_d, $this->table_a, $officer_id, $user_access_level);

        return $fetch_sum_debit;

    }
    public function fetch_sum_total_cr_transactions_for_today(string $officer_id, string $user_access_level, MDLSecureDashboard $mds) : array{

        $fetch_sum_credit = $mds->fetch_sum_total_cr_transactions_for_today_mdl($this->table_b, $this->table_c, $this->table_d, $this->table_a, $officer_id, $user_access_level);

        return $fetch_sum_credit;

    }
}
