<?php
// Instantiate connection to database
ob_start();
require_once('./config/dbConfig.php');
$object = new Database();
$object->connect();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <title>Fefes Blog Clone</title>
</head>

<body>

    <body class="text-center">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Offcanvas navbar large">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Fefes Blog Clone</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasNavbar2Label">Fefes Blog Clone</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                            <li class="nav-item">
                                <a class="nav-link" href="auth/">Login</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>


        <div class="container h-100 mt-5">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-9">
                    <?php
                    //Get the encrypted tag id and decrypt for filtering
                    $filter = 0;
                    if (isset($_GET['tag'])) {
                        list($_GET['tag'], $enc_iv) = explode("::", $_GET['tag']);
                        $cipher_method = 'aes-128-ctr';
                        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
                        $token = openssl_decrypt($_GET['tag'], $cipher_method, $enc_key, 0, hex2bin($enc_iv));
                        $filter = $token;
                        unset($token, $cipher_method, $enc_key, $enc_iv);
                    }

                    //Fetch all blogs to filter from
                    $sql = "SELECT * FROM blogs ORDER BY id ASC;";
                    $stmt = $object->connect()->prepare($sql);
                    $stmt->execute();
                    if ($stmt->rowCount()) {
                        while ($rows = $stmt->fetch()) {
                            $token = $rows['id'];
                            if ($filter == 0) {
                                //Initial render of blogs if no specific tag is selected
                                echo '
                                <div class="my-3 p-3 bg-body rounded shadow-sm">
                                    <h1 class="border-bottom pb-2 mb-0">' . $rows['title'] . '</h1>
                                    <div class="d-flex text-body-secondary pt-3">
                                        <p class="pb-3 mb-0 small lh-sm">' . $rows['body'] . '</p>
                                    </div>
                                    <div class="d-flex text-body-secondary pt-3">
                                        <p class="pb-3 mb-0 small lh-sm">Posted: ' . $rows['date_created'] . '</p>
                                    </div>';
                                //Get Tags from One-To-Many relationship
                                $tagsql = "SELECT * FROM blogs_tags a, tags b WHERE a.tag = b.id AND blog = ?;";
                                $tagstmt = $object->connect()->prepare($tagsql);
                                $tagstmt->bindvalue(1, $rows['id']);
                                $tagstmt->execute();
                                echo '<div class="d-flex text-body-secondary pt-3">
                                        <p class="pb-3 mb-0 small lh-sm"> Tags: </p>';
                                while ($tagrows = $tagstmt->fetch()) {
                                    echo '
                                        <p class="pb-3 mb-0 small lh-sm" style="margin-left:10px"> #' . $tagrows['tag'] . ' </p>
                                    ';
                                }

                                echo '</div></div>';
                            } else {
                                //Get Tags from One-To-Many relationship when tag iID is supplied and render the blog cards
                                $tagsql = "SELECT * FROM blogs_tags a, tags b WHERE a.tag = b.id AND blog = ? AND a.tag = ?;";
                                $tagstmt = $object->connect()->prepare($tagsql);
                                $tagstmt->bindvalue(1, $rows['id']);
                                $tagstmt->bindvalue(2, $filter);
                                $tagstmt->execute();
                                while ($tagrows = $tagstmt->fetch()) {
                                    $cipher_method = 'aes-128-ctr';
                                    $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
                                    $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
                                    $crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
                                    echo '<div class="my-3 p-3 bg-body rounded shadow-sm">
                                    <h1 class="border-bottom pb-2 mb-0">' . $rows['title'] . '</h1>
                                    <div class="d-flex text-body-secondary pt-3">
                                        <p class="pb-3 mb-0 small lh-sm">' . $rows['body'] . '</p>
                                    </div>
                                    <div class="d-flex text-body-secondary pt-3">
                                        <p class="pb-3 mb-0 small lh-sm">Posted: ' . $rows['date_created'] . '</p>
                                    </div>
                                    ';

                                    echo '
                                    <div class="d-flex text-body-secondary pt-3"><p class="pb-3 mb-0 small lh-sm"> Tags: </p>';
                                    echo '<p class="pb-3 mb-0 small lh-sm" style="margin-left:10px">  #' . $tagrows['tag'] . ' </p>';
                                    echo '</div></div>';
                                }
                            }
                        }
                    } else {
                        //Shown when there are no blogs posted
                        echo '
                              <div class="container my-5">
                                <div class="bg-body-tertiary p-5 rounded">
                                    <div class="col-sm-8 py-5 mx-auto">
                                        <h1 class="display-5 fw-normal">No Blogs Yet!</h1>
                                        <p class="fs-5">Post one <a href="./">here</a></p>
                                        
                                    </div>
                                </div>
                            </div>';
                    }

                    ?>
                </div>
                <div class="col-3">
                    <h2>Available Tags</h2>
                    <ul class="list-unstyled ps-3">
                        <li><a class="d-inline-flex align-items-center rounded text-decoration-none">All</a>
                            <a href="./" class="btn btn-info btn-sm" style="color:white">Show</a>
                        </li><br />
                        <?php
                            //Show a list of all tags to filter from
                            $sql = "SELECT * FROM tags ORDER BY id ASC;";
                            $stmt = $object->connect()->prepare($sql);
                            $stmt->execute();
                            while ($rows = $stmt->fetch()) {
                                $id = $rows['id'];

                                $token = $id;

                                $cipher_method = 'aes-128-ctr';
                                $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
                                $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
                                $crypted_token = openssl_encrypt($token, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
                                echo '<li><a class="d-inline-flex align-items-center rounded text-decoration-none">' . $rows['tag'] . '</a> 
                                    <a href="./?tag=' . $crypted_token . '" class="btn btn-info btn-sm" style="color:white">Show</a></li><br/>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
            <script src="../ajax/blog.js"></script>
    </body>

</html>