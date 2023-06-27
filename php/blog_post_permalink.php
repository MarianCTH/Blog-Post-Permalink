<?php
//test if the user is logged in if you have a login system
/*
    session_start();
    if (!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION["rol"] == 'Administrator')) { //test if the user is logged and is administrator else redirect
        header("Location: ../index.html");
        exit();
    }
*/

// establish a connection
// for example include 'config.php';
ini_set('error_log', 'error.log');
require_once 'config.php';

$stmt = $db->prepare("INSERT INTO blog (ID_author, Subject, Text, Image, Category, Tags, Permalink) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssss", $ID_author, $Subject, $Text, $Image, $Category, $Tags, $permalink);

$ID_author = 1; //$ID_author = $_SESSION['id']; if you have a user that's logged in
$Subject = $_POST["subject"];
$Text = $_POST["content"];

$targetDir = "../images/";
if (isset($_FILES["image"]) && $_FILES["image"]["size"] > 0) {
    $Image = $_FILES["image"]["name"];
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        error_log('Image uploaded: ' . $Image);
    } 
    else {
        error_log('Error moving the uploaded file');
    }
} 
else {
    $Image = "";
    error_log('No image uploaded');
}
$Category = $_POST["category"];
$Tags = $_POST["tags"];
$permalink = str_replace([' ', '/'], '-', $Subject);

$stmt->execute();

if ($stmt->affected_rows > 0) {
    $sql = "SELECT post_ID FROM blog WHERE Subject = '$Subject'";
    $result = $db->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $postID = $row['post_ID'];
    }

    //serach for 'RewriteEngine ON' and place the rule right after in .htacces file
    $htaccessFile = '../.htaccess';
    $lineToAdd = "RewriteRule ^" . $permalink . "$ blog.php?id=" . $postID . " [L,NC]";
    $htaccessContent = file_get_contents($htaccessFile);
    $search = "RewriteEngine on";
    $replacement = $search . PHP_EOL . $lineToAdd;
    $htaccessContent = str_replace($search, $replacement, $htaccessContent);

    if (file_put_contents($htaccessFile, $htaccessContent)) {
        error_log('The rewrite rule has been added to the .htaccess file.');
    } 
    else {
        error_log('Failed to add the rewrite rule to the .htaccess file.');
    }
} 
else {
    error_log('Error inserting data.');
}

$stmt->close();
$db->close();
?>
