<?php
    ob_start();
    session_start();
    require_once('../../config/dbConfig.php');
    $object = new Database();
    $object->connect();

    class Blogs extends Database
    {
        /* Blog managing Class */
        public $tags;
        public $title;
        public $body;

        function addBlog($title, $body, $tags)
        {
            // Created a blog in the databse table
            try {
                $sql = "INSERT INTO blogs(title,body, date_created,user) VALUES(?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $title);
                $stmt->bindvalue(2, $body);
                $stmt->bindvalue(3, date('Y-m-d H:i:s'));
                $stmt->bindvalue(4, $_SESSION['person']);
                if ($stmt->execute()) {
                    //Map Blog object to the tags in the blog to tag table
                    $sql = "SELECT id FROM blogs WHERE title = ? AND body = ?;";
                    $stmt = $this->connect()->prepare($sql);
                    $stmt->bindvalue(1, $title);
                    $stmt->bindvalue(2, $body);
                    $stmt->execute();
                    $rows = $stmt->fetch();
                    $id = $rows['id'];
                    //save One-to-Many relation
                    $sqlMM = "INSERT INTO blogs_tags(blog,tag) VALUES(?,?);";
                    $omStmt = $this->connect()->prepare($sqlMM);
                    foreach ($tags as $selectedOption)
                    {
                        //Decrypt Tag ID
                        list($selectedOption, $enc_iv) = explode("::", $selectedOption);
                        $cipher_method = 'aes-128-ctr';
                        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
                        $token = openssl_decrypt($selectedOption, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
                        $tagID = $token;
                        //Save relationship
                        $omStmt->bindvalue(1, $id);
                        $omStmt->bindvalue(2, $tagID);
                        $omStmt->execute();
                        unset($token, $cipher_method, $enc_key, $enc_iv);
                    }
                    echo "200";
                    
                } else {
                    echo "401";
                }
            } catch (PDOException $e) {
                echo "500" . $e->getMessage();
                //.$e->getMessage()
            }
        }

        function oneToManyRelationship(){
            
        }

    }

    $_blogs = new Blogs();


    if (isset($_POST['tags'])) {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $tags = $_POST['tags'];
        $_blogs->addBlog($title, $body, $tags);
    }
?>