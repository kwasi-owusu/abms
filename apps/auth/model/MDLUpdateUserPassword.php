<?php

require_once dirname(__DIR__, 1) . '/interfaces/ISecuredChangePassword.php';

class MDLUpdateUserPassword implements ISecuredChangePassword
{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO)
    {

        $this->newPDO       = new ConnectDatabase();
        $this->thisPDO      = $this->newPDO->Connect();
    }


    public function is_user_still_active(array $data, string $table_a): int
    {

        $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a WHERE user_id = :d AND user_status = 1 LIMIT 1");
        $stmt->bindParam(':d', $data['user_id'], PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }

    public function change_user_password(string $table_a, string $table_b, array $data): object
    {

        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        if ($thisPDO->beginTransaction()) {
            try {


                $stmt = $thisPDO->prepare("UPDATE $table_a SET password = :pd WHERE user_id = :d");
                $stmt->bindParam(':d', $data['user_id'], PDO::PARAM_INT);
                $stmt->bindParam(':pd', $data['ps'], PDO::PARAM_STR);
                $stmt->execute();

                $stmt_a = $thisPDO->prepare("UPDATE $table_b SET password = :pd WHERE user_id = :d");
                $stmt_a->bindParam(':d', $data['user_id'], PDO::PARAM_INT);
                $stmt_a->bindParam(':pd', $data['ps'], PDO::PARAM_STR);
                $stmt_a->execute();

                $thisPDO->commit();

                return $stmt;
            } catch (PDOException $e) {
                $thisPDO->rollBack();
                echo "Error";
            }
        }
    }
}
