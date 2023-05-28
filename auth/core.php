<?php
    ob_start();
    session_start();
    require_once('../config/dbConfig.php');
    $object = new Database();
    $object->connect();

    class Auth extends Database
    {
        public $username;
        public $password;
        public function login($username, $password)
        {
            try {
                $sql = "SELECT * FROM users WHERE username = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $username);
                $stmt->execute();
                if ($stmt->rowCount()) {
                    $row = $stmt->fetch();
                    $DB_Password = $row['password'];
                    $FinalPassword = password_verify($password, $DB_Password);
                    if ($FinalPassword === true) {
                    //$location = "../admin/pages/";
                        echo 'Success';
                    } else {
                        echo 'Invalid Username or Password';
                    }
                } else {
                    echo 'Invalid Username or Password';
                }
            } catch (PDOException $e) {
                echo "Error";
            }
        }
    }

    $auth = new Auth();

    if (isset($_POST['password'])) 
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $auth->login($username, $password);
    }
?>