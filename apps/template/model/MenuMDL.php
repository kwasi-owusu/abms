<?php
//require_once '../../template/statics/conn/connection.php';

require_once dirname(__DIR__) . '/statics/db/ConnectDatabase.php';

class Menu
{
    private $newPDO;
    private $thisPDO;

    public function __construct($newPDO, $thisPDO)
    {

        $this->newPDO       = new ConnectDatabase();
        $this->thisPDO      = $this->newPDO->Connect();
    }

    public function createMenu($table, $table_b, $table_c, $table_d, $table_e, $data)
    {


        try {

            if ($data['usr'] != 1) {
                //user is a super admin
                $stmt =  $this->thisPDO->prepare("SELECT *
                FROM $table
                ");

                $stmt->execute();

                return $stmt;
            }
        } catch (PDOException $e) {

            echo $e->getMessage();
        }
    }

    public function subMenu($menu_ID, $table_b, $table_d, $userRole, $user_ID)
    {
        if ($userRole == 1) {
            //user is a super admin
            $stmt =  $this->thisPDO->prepare("SELECT $table_b.*
                FROM $table_b 
                WHERE $table_b.menu = :md
                ");

            $stmt->bindParam('md', $menu_ID, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt;
        } elseif ($userRole == 2) {
            // user is a merchant admin

            $stmt =  $this->thisPDO->prepare("SELECT $table_b.*
                FROM $table_b

                WHERE $table_b.menu = :md
                ");

            $stmt->bindParam('md', $menu_ID, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt;
        } else {
            $stmt =  $this->thisPDO->prepare("SELECT $table_b.*, $table_d.*
            FROM $table_b 
            
            WHERE $table_d.menu_ID = :md
                        
            AND $table_d.user_ID = :usr
            ");

            $stmt->bindParam('md', $menu_ID, PDO::PARAM_STR);
            $stmt->bindParam('usr', $user_ID, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt;
        }
    }
}
