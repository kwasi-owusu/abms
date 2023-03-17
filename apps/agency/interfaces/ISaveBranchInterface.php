<?php

interface ISaveBranchInterface{
    public function is_branch_exist(string $table_a, string $agent_id, string $branch_name) : int;
    public function is_officer_permitted(string $table_a, string $permission_id, string $officer_id) : int;
    public function is_branch_registration_allowed(string $table_a, string $agent_id) : object;
    public function save_this_branch(string $table_a, string $table_b, string $data) : object;   
    public function change_branch_status(string $table_a, string $table_b, string $branch_id, string $officer_id, string $new_branch_status) : object;
}