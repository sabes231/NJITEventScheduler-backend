<?php

  include_once('DataBaseConnection.php');
  
  $UserID = $_POST['UserID'];
  $DatabaseConnection = new DataBaseConnection();

  echo $DatabaseConnection->getRole($UserID);
  
  
  $DatabaseConnection->disconnect();

?>
