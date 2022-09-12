<?php


class ConnectDatabase
{
    public function Connect(){
        try {
            $PDO = new PDO("mysql:host=localhost;dbname=abms", "u@agent_user_2", "fd2+gk*0-6*XHI%*%cMn");
            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $PDO->exec("set names utf8");

            return $PDO;
        }
        catch(PDOException $e)
        {
            //echo $e->getMessage();
            echo "Agency Banking Is Down.";
        }

    }
}