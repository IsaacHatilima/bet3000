<?php
// Instantiate connection to database
ob_start();
require_once('../../config/dbConfig.php');
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
        <div class="container">
            <header class="d-flex justify-content-center py-3">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="." class="nav-link" aria-current="page">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Blogs</a></li>
                    <li class="nav-item"><a href="./tags" class="nav-link active">Tags</a></li>
                </ul>
            </header>
        </div>
        <div class="container h-100 mt-5">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-6">
                    <div class="alert alert-primary" role="alert" style="display: none;" id="_alert">
                        <span id="msg"></span>
                    </div>
                    <form>
                        <div class="form-group">
                            <label>Tag</label>
                            <input type="text" class="form-control" name="tag" id="tag">
                        </div>
                        <button class="w-50 mt-5 btn btn-lg btn-primary" type="submit" id="save_tag">Save</button>
                    </form>
                </div>
                <div class="col-6">
                    <h1>Tags</h1>
                    <div class="alert alert-primary" role="alert" style="display: none;" id="_delAlert">
                        <span id="delMsg"></span>
                    </div>
                    <ul class="list-unstyled ps-3">
                        <?php
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
                                <button type="button" class="btn btn-danger btn-sm" style="color:white" id="' . $crypted_token . '" onclick="Deletes(this.id);">Delete</button></li><br/>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
            <script src="../ajax/tagJS.js"></script>
    </body>

</html>