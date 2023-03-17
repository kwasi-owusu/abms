<?php

require_once dirname(__DIR__) . '/interfaces/ISaveBranchInterface.php';

class MDLSaveBranch implements ISaveBranchInterface
{

    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO)
    {

        $this->newPDO       = $newPDO;
        $this->thisPDO      = $thisPDO;
    }


    public function is_branch_exist(string $table_a, string $agent_id, string $branch_name): int
    {

        $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a WHERE $agent_id = :agd AND $branch_name = :brn LIMIT 1");
        $stmt->bindParam(':agd', $agent_id, PDO::PARAM_INT);
        $stmt->bindParam(':brn', $branch_name, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->rowCount();
    }


    public function is_officer_permitted(string $table_a, string $permission_id, string $officer_id): int
    {

        $stmt = $this->thisPDO->prepare("SELECT * FROM $table_a WHERE $permission_id = :pmd AND $officer_id = :ofd LIMIT 1");
        $stmt->bindParam(':pmd', $permission_id, PDO::PARAM_INT);
        $stmt->bindParam(':ofd', $officer_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->rowCount();
    }


    public function is_branch_registration_allowed(string $table_a, string $agent_id): object
    {

        $stmt = $this->thisPDO->prepare("SELECT allow_branch_registration FROM $table_a WHERE agency_id = :agd LIMIT 1");
        $stmt->bindParam(':agd', $agent_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }


    public function save_this_branch(string $table_a, string $table_b, string $data): object
    {
        $newPDO = new ConnectDatabase();
        $thisPDO = $newPDO->Connect();

        if ($thisPDO->beginTransaction()) {
            try {
                $stmt   = $thisPDO->prepare("INSERT INTO $table_a(branch_name, branch_code, branch_contact_number, branch_address, branch_email, 
                branch_manager, agency_id, branch_key, added_by) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)");

                $stmt->execute(array(
                    $data['branch_name'],
                    $data['branch_code'],
                    $data['branch_contact_number'],
                    $data['branch_address'],
                    $data['branch_email'],
                    $data['branch_manager'],
                    $data['agency_id'],
                    $data['branch_key'],
                    $data['added_by']
                ));

                $last_id = $thisPDO->lastInsertId();

                $stmt_c = $thisPDO->prepare("INSERT INTO $table_b(activity_module, activity_desc, user_id) VALUES(?, ?, ?)");
                $stmt_c->execute(
                    array(
                        $data['activity_module'],
                        $data['activity_desc'],
                        $data['user_id']
                    )
                );

                $thisPDO->commit();

                return $stmt;
            } catch (PDOException $e) {
                $thisPDO->rollBack();
                echo "Error";
            }
        }
    }

    public function change_branch_status(string $table_a, string $table_b, string $branch_id, string $officer_id, string $new_branch_status): object
    {

        if ($new_branch_status != 1) {

            $newPDO = new ConnectDatabase();
            $thisPDO = $newPDO->Connect();

            if ($thisPDO->beginTransaction()) {
                try {

                    $stmt = $this->thisPDO->prepare("UPDATE $table_a SET branch_status = :nbs WHERE branch_id = :bnk");
                    $stmt->bindParam(':nbs', $new_branch_status, PDO::PARAM_INT);
                    $stmt->bindParam(':bnk', $branch_id, PDO::PARAM_INT);
                    $stmt->execute();



                    $stmt_a = $this->thisPDO->prepare("UPDATE $table_b SET user_status = 0 WHERE user_branch = :bnk");
                    $stmt_a->bindParam(':bnk', $branch_id, PDO::PARAM_INT);
                    $stmt_a->execute();

                    $thisPDO->commit();

                    return $stmt;
                } catch (PDOException $e) {
                    $thisPDO->rollBack();
                    echo "Error";
                }
            }
        } else {
            $stmt = $this->thisPDO->prepare("UPDATE $table_a SET branch_status = :nbs WHERE branch_id = :bnk");
            $stmt->bindParam(':nbs', $new_branch_status, PDO::PARAM_INT);
            $stmt->bindParam(':bnk', $branch_id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt;
        }
    }
}
