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
    <title>Fefes Blog Clone</title>
</head>

<body>
    
</body>

</html>