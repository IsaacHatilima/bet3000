<?php
    ob_start();
    session_start();
    require_once('../../config/dbConfig.php');
    $object = new Database();
    $object->connect();

    class Auth extends Database
    {
        /* Auth class with login method that takes in username and password. The method checks for a user with the username and then verifies the password. */
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
                        echo '200'; //Successful Login
                    } else {
                        echo '404'; //Invalid Password
                    }
                } else {
                    echo '404'; //Invalid Password
                }
            } catch (PDOException $e) {
                echo "5002";
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