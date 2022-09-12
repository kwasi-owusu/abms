<?php

require_once dirname(__DIR__) . '/controller/ISecureLoginInterface.php';

class CTRLSecureLogin implements ISecureLoginInterface{


    public function is_login_has_valid(string $page_name, string $hash_key) : string {
        
        $page_is        = $page_name;
        $thi_is_is      = $hash_key;
        $rock_hash      = $page_is.$thi_is_is;

        $loginTkn = hash_hmac('sha512', $rock_hash, $thi_is_is);


        return $loginTkn;
        
    }
}