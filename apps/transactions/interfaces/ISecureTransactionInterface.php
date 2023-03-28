<?php

interface ISecureTransactionInterface{

    public function is_agent_active(string $agent_key) : int;
    public function is_branch_active(string $agent_id, string $branch_key): int;
    public function is_officer_active(string $agent_id, string $officer_id): int;
    public function has_branch_got_enough_balance(int $agency_id, int $branch_id): object;
    public function is_transaction_allowed() : int;
    public function is_transaction_limit_reached(string $account_number, string $account_name, string $current_transaction_limit) : object;
    public function is_transaction_allowed_for_agent(string $agent_key) : int;
    public function is_pos_terminal_authorized(int $agent_id, string $pos_dna) : int;
}