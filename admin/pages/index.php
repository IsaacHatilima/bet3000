<?php include '../includes/header.php'; ?>

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
                                <a class="nav-link active" aria-current="page" href=".">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./blogs">Blogs</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./tags">Tags</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../core/logout">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="container h-100 mt-5">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-10">
                    <div class="alert alert-primary" role="alert" style="display: none;" id="_alert">
                        <span id="msg"></span>
                    </div>
                    <form>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" class="form-control" name="title" id="title">
                        </div>


                        <div class="form-group">
                            <label>Body</label>
                            <textarea class="form-control" rows="15" name="body" id="body"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Tags (Multi Select)</label>
                            <select class="selectpicker form-control" multiple data-live-search="true" id="tags" name="tags">
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
                                    echo '<option value="' . $crypted_token . '">' . $rows['tag'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <button class="w-50 mt-5 btn btn-lg btn-primary" type="submit" id="post">Post</button>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
        <script src="../ajax/blog.js"></script>
    </body>

    </html>