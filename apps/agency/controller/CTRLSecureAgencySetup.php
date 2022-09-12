<?php
require_once dirname(__DIR__) . '/model/MDLSecureAgencySetup.php';

require_once dirname(__DIR__) . '/controller/ISaveAgencyInterface.php';


class CTRLSecureAgencySetup implements ISaveAgencyInterface
{

    public function is_agent_exist(string $table_a, string $agency_code, string $agency_name): int
    {
     
        $getRst = MDLSecureAgencySetup::check_if_agent_exist($table_a, $agency_code, $agency_name);

        return $getRst;
    }

    public function is_officer_permitted(string $user_permissions, string $officer_id) : int{

        $permission = "setup_agency";

        $getRst =  MDLSecureAgencySetup::check_if_officer_is_permitted($user_permissions, $permission, $officer_id);
        
        
        return $getRst;
    }


    public function is_agency_registration_allowed(string $geneal_settings) : int {

        $col        = "settings_desc";
        $col_val    = "allow_agent_register";

        $getRst = MDLSecureAgencySetup::check_if_agency_registration_is_allowed($geneal_settings, $col, $col_val);
        $fetchRst = $getRst->fetch(PDO::FETCH_ASSOC);

        $val = $fetchRst['settings_value'];

        return $val;
    }
}
