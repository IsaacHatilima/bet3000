<?php
    ob_start();
    session_start();
    require_once('../../config/dbConfig.php');
    $object = new Database();
    $object->connect();

    class Tags extends Database
    {
        /* CRUD class for Tags  */
        public $tag;
        function addTag($tag)
        {
            // Created a tag in the databse table
            try {
                $sql = "INSERT INTO tags(tag,date_created,user) VALUES(?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $tag);
                $stmt->bindvalue(2, date('Y-m-d H:i:s'));
                $stmt->bindvalue(3, $_SESSION['person']);
                if ($stmt->execute()) {
                    echo "200";
                } else {
                    echo "401";
                }
            } catch (PDOException $e) {
                echo "500";
                //.$e->getMessage()
            }
        }

        function deleteTag($tagID)
        {
            //Delete Tag by ID
            try {
                $sql = "DELETE FROM tags WHERE id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $tagID);
                if ($stmt->execute()) {
                    echo "200";
                } else {
                    echo "401";
                }
            } catch (PDOException $e) {
                echo '500';
            }
        }
    }

    $_tags = new Tags();

    if (isset($_POST['tag'])) 
    {
        $tag = $_POST['tag'];
        $_tags->addTag($tag);
    }

    // Decrypt ID in readiness for record deleting
    if (isset($_POST['deleteID'])) {
        $id = $_POST['deleteID'];
        list($id, $enc_iv) = explode("::", $id);
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($id, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $tagID = $token;
        $_tags->deleteTag($tagID);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }
