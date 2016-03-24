<?php

  include_once('DataBaseConnection.php');
  
  $Date = $_POST['Date'];
  $Approved = $_POST['Approved'];
  
  #echo $username;
  
  $DatabaseConnection = new DataBaseConnection();
  
  
  
  #echo '<br/> getEventsbyWeek: ".$Date." <br/>';
  $events = $DatabaseConnection->getEventsbyWeek($Date,$Approved);
  echo json_encode(json_decode($events,true),JSON_PRETTY_PRINT);
  $DatabaseConnection->disconnect();

?>
