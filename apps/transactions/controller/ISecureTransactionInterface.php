<?php

interface ISecureTransactionInterface{

    public function is_agent_active(string $sec_table_a, string $agent_id, string $agent_key) : int;
    public function is_branch_active(string $table_d, string $agent_id, string $agency_branch, string $branch_key): int;
    public function is_officer_active(string $sec_table_c, string $agent_id, string $officer_id, string $user_key): int;
    public function is_transaction_allowed(string $sec_table_d) : int;
    public function is_transaction_limit_reached(string $table_a, string $account_number, string $account_name, string $current_transaction_limit) : int;
    public function is_transaction_allowed_for_agent(string $agent_setup_tbl, string $agent_key) : int;
}