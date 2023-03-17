<?php

interface ISecureLoginInterface{
    public function is_login_hash_valid(string $page_name, string $hash_key) : string;
    public function is_branch_still_active(int $user_branch) : int;
    public function is_agency_still_active(int $user_institution) : int;
    public function is_password_valid(string $officer_id, string $password) : array;
}