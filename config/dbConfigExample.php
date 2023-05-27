<?php
class Database
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $charset;

    public function connect()
    {
        $this->servername = "localhost";
        $this->username = "yourMySQLUsername";
        $this->password = "YourPassword";
        $this->dbname = "bet";
        $this->charset = "utf8mb4";

        try {
            $dsn = "mysql:host=" . $this->servername . ";dbname=" . $this->dbname . ";charset=" . $this->charset;
            // $dsn = "sqlsrv:SERVER=".$this->servername.";DATABASE=".$this->dbname hatilima_pos.20;
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Connection Failed: " . $e->getMessage();
        }
    }
}
