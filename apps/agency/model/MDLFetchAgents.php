<?php

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';

class MDLFetchAgents extends ConnectDatabase{

    public function fetchAllAgents($table_a){

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $stmt = $thisPDO->prepare("SELECT * FROM $table_a");
        $stmt->execute();

        return $stmt;

    }


    public function fetchThisAgent($table_a, $data){


        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $stmt = $thisPDO->prepare("SELECT * FROM $table_a WHERE agency_id = :d OR agency_code = :dd OR agency_key = :ddd");
        $stmt->bindValue(':d', $data['agency_id'], PDO::PARAM_STR);
        $stmt->bindValue(':dd', $data['agency_code'], PDO::PARAM_STR);
        $stmt->bindValue(':ddd', $data['agency_key'], PDO::PARAM_STR);
        $stmt->execute();

        return $stmt;

    }

    public function fetchActiveAgent($table_a){

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $stmt = $thisPDO->prepare("SELECT * FROM $table_a WHERE agency_status = 1");
        $stmt->execute();

        return $stmt;

    }

    public function fetchDeactivatedAgent($table_a){
        

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        $stmt = $thisPDO->prepare("SELECT * FROM $table_a WHERE agency_status = 0");
        $stmt->execute();

        return $stmt;
    }
}