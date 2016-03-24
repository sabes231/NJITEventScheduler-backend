<?php
$Password = $_POST['Password'];
$Hashed =  hash("sha256", $Password);
echo $Hashed;
?>
