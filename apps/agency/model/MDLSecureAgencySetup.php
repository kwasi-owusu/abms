<?php

class MDLSecureAgencySetup extends ConnectDatabase{

    public static function check_if_agent_exist(string $table_a, string $agency_code, string $agent_name){

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $stmt = $thisPDO->prepare("SELECT * FROM $table_a WHERE agency_code = :agc OR agency_name = :agn LIMIT 1");
        $stmt->bindParam(':agc', $agency_code, PDO::PARAM_STR);
        $stmt->bindParam(':agn', $agent_name, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->rowCount();
    }

    public static function check_if_officer_is_permitted(string $user_roles, string $permission, string $officer_id){
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $stmt = $thisPDO->prepare("SELECT * FROM $user_roles WHERE permission_desc = :pm AND officer_id = :ofd");
        $stmt->bindValue(':pm', $permission, PDO::PARAM_STR);
        $stmt->bindValue(':ofd', $officer_id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount();
    }
    
    public static function check_if_agency_registration_is_allowed(string $geneal_settings, $col_val){
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $stmt = $thisPDO->prepare("SELECT * FROM $geneal_settings WHERE settings_desc = :val LIMIT 1");
        $stmt->bindValue(':val', $col_val, PDO::PARAM_STR);
        
        $stmt->execute();

        return $stmt;
    }
}