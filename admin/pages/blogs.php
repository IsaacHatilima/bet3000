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
                                <a class="nav-link" href=".">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="./blogs">Blogs</a>
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
                <div class="alert alert-primary" role="alert" style="display: none;" id="_delAlert">
                    <span id="delMsg"></span>
                </div>
                <div class="col-12">
                    <?php
                    // Get all blogs
                    $sql = "SELECT * FROM blogs ORDER BY id ASC;";
                    $stmt = $object->connect()->prepare($sql);
                    $stmt->execute();
                    if ($stmt->rowCount()) {
                        while ($rows = $stmt->fetch()) {
                            $token = $rows['id'];

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
                            //Get Tags from One-To-Many relationship
                            $tagsql = "SELECT * FROM blogs_tags a, tags b WHERE a.tag = b.id AND blog = ?;";
                            $tagstmt = $object->connect()->prepare($tagsql);
                            $tagstmt->bindvalue(1, $rows['id']);
                            $tagstmt->execute();
                            while ($tagrows = $tagstmt->fetch()) {
                                echo '<p class="pb-3 mb-0 small lh-sm" style="margin-left:10px">  #' . $tagrows['tag'] . ' </p>';
                            }
                            echo '</div>';
                            echo '<button type="button" class="btn btn-danger btn-sm" style="color:white" id="' . $crypted_token . '" onclick="Deletes(this.id);">Delete</button>
                                        </div>';
                        }
                    } else {
                        //Shown if no blogs are created
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
            </div>
            <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
            <script src="../ajax/blog.js"></script>
    </body>

    </html>