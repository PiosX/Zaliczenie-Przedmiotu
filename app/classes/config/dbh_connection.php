<?php
namespace Classes\Config;
    class Dbh
    {
        protected function connect()
        {
            require_once("config.php");
            try
            {
                $options = array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'UTF8'",
                    \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION
                );

                $pdo = 'mysql:host='.DB_HOST.';dbname='.DB_DATABASE;
                $conn = new \PDO($pdo, DB_USER, DB_PASSWORD, $options);
                $conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
                return $conn;
            }
            catch(\PDOException $e)
            {
                echo "Error: ".$e->getMessage();
            }
            
        }
    }