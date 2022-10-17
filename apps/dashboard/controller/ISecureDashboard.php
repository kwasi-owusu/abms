<?php

interface ISecureDashboard{
    public function check_total_active_user(string $officer_id, string $user_access_level, MDLSecureDashboard $mds) : int;
    public function check_total_users_logged_in(string $officer_id, string $user_access_level, MDLSecureDashboard $mds) : int;
    public function check_total_active_agencies(string $officer_id, string $user_access_level, MDLSecureDashboard $mds) : int;
    public function check_total_active_branches(string $officer_id, string $user_access_level, MDLSecureDashboard $mds) : int;
    public function fetch_transactions_for_today(string $officer_id, string $user_access_level, MDLSecureDashboard $mds) : array;

    public function fetch_total_number_of_transactions_for_today(string $officer_id, string $user_access_level, MDLSecureDashboard $mds) : int;
    public function fetch_total_successful_transactions_for_today(string $officer_id, string $user_access_level, MDLSecureDashboard $mds) : int;

    public function fetch_total_dr_transactions_for_today(string $officer_id, string $user_access_level, MDLSecureDashboard $mds) : int;
    public function fetch_total_cr_transactions_for_today(string $officer_id, string $user_access_level, MDLSecureDashboard $mds) : int;

    public function fetch_sum_total_dr_transactions_for_today(string $officer_id, string $user_access_level, MDLSecureDashboard $mds) : array;
    public function fetch_sum_total_cr_transactions_for_today(string $officer_id, string $user_access_level, MDLSecureDashboard $mds) : array;
}