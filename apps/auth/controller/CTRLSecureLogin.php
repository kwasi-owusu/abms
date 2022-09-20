<?php

require_once dirname(__DIR__) . '/controller/ISecureLoginInterface.php';
require_once dirname(__DIR__) . '/model/MDLSecureLogin.php';

class CTRLSecureLogin implements ISecureLoginInterface{


    public function is_login_hash_valid(string $page_name, string $hash_key) : string {
        
        $page_is        = $page_name;
        $thi_is_is      = $hash_key;
        $rock_hash      = $page_is.$thi_is_is;

        $loginTkn = hash_hmac('sha512', $rock_hash, $thi_is_is);


        return $loginTkn;
        
    }

    public function is_branch_still_active(int $user_branch) : int{


        $table = 'agency_branches';
        $check_branch_active_instance = new MDLSecureLogin();

        $getRst = $check_branch_active_instance->is_branch_still_active_mdl($user_branch, $table);

        return $getRst;

    }

    public function is_agency_still_active(int $user_institution) : int{

        $table = 'agency_setup';
        $check_agency_active_instance = new MDLSecureLogin();

        $getRst = $check_agency_active_instance->is_agency_still_active_mdl($user_institution, $table);

        return $getRst;


    }

    public function is_password_valid(string $officer_id, string $password) : array{

        $table = 'password_logs';
        $check_if_password_is_valid = new MDLSecureLogin();

        $getRst = $check_if_password_is_valid->is_password_valid_mdl($officer_id, $password, $table);

        return $getRst;
    }
}