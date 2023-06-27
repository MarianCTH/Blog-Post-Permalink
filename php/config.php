<?php
define('DB_SERVER', 'YOUR_DB_IP');
define('DB_USERNAME', 'YOUR_DB_USER');
define('DB_PASSWORD', 'YOUR_DB_PASSWORD');
define('DB_NAME', 'YOUR_DB_NAME');

$db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
$db->set_charset("utf8mb4"); //for romanian letters(and other special characters...)

if($db === false){
    die("ERROR: Failed the connection to the database." . mysqli_connect_error());
}
?>