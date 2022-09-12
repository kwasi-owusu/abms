<?php

require_once dirname(__DIR__, 2) . '/template/statics/db/ConnectDatabase.php';
class MDLFetchUsers{

    public static function loginUser($table_a, $table_b, $data){
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        try{
        $stmt = $thisPDO->prepare("SELECT *  FROM $table_a WHERE email = :m AND password =:p LIMIT 1");
        $stmt->bindParam(':m', $data['em'], PDO::PARAM_STR);
        $stmt->bindParam(':p', $data['ps'], PDO::PARAM_STR);

        $stmt->execute();

        return $stmt;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}