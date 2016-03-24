<?php

  include_once('DataBaseConnection.php');
  
  $username = $_POST['userName'];
  $Password = $_POST['Password'];
  
  #echo $username;
  
  $user = new User($username,$Password);
  
  $DatabaseConnection = new DataBaseConnection();
  
  $result = $DatabaseConnection->checkLogin($user);
  echo $result;
  
  $DatabaseConnection->disconnect();

?>
