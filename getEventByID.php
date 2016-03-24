<?php

  include_once('DataBaseConnection.php');
  
  $ID = $_POST['ID'];

  
  #echo $ID;
  
  $DatabaseConnection = new DataBaseConnection();
  
  
  
  #echo '<br/> getEventsbyWeek: ".$Date." <br/>';
  $events = $DatabaseConnection->getEventByID($ID);
  echo json_encode(json_decode($events,true),JSON_PRETTY_PRINT);
  $DatabaseConnection->disconnect();

?>