<?php
class Database
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $charset;
    private $port;

    public function connect()
    {
        $this->servername = "127.0.0.1";
        $this->username = "DBUsername";
        $this->password = "DBPassword";
        $this->dbname = "bet";
        $this->charset = "utf8mb4";
        $this->port = "3306";

        try {
            $dsn = "mysql:host=" . $this->servername . ';port=' . $this->port . ";dbname=" . $this->dbname . ";charset=" . $this->charset;
            $pdo = new PDO($dsn, $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Connection Failed: " . $e->getMessage();
        }
    }
}
