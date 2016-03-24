<?php

  include_once('DataBaseConnection.php');
  
  $ID = $_POST['ID'];
  
  
  #echo $username;
  
  $DatabaseConnection = new DataBaseConnection();
  
  
  
  #echo '<br/> getEventsbyWeek: ".$Date." <br/>';
  $DatabaseConnection->DeleteEvent($ID);
  $DatabaseConnection->disconnect();

?>
