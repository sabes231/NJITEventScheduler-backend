<?php

  include_once('DataBaseConnection.php');
  
  $username = $_POST['userName'];
  $Password = $_POST['Password'];
  
  #echo $username;
  
  $user = new User($username,$Password);
  
  $DatabaseConnection = new DataBaseConnection();
  
  $result = $DatabaseConnection->checkLogin($user);
  echo "Result: ".$result;
  $result = json_decode($result,true);
  
  echo "<br/>";
  echo 'UserID: '. $result['UserID']."<br/>";
  echo "<br/>";
  echo 'RoleID: '. $result['Role']."<br/>";

  echo $DatabaseConnection->getRole($result['UserID']);
  
  echo '<br/> getEventByDate: 03-22-2016 <br/>';
  $events = $DatabaseConnection->getEventsbyDate('03-22-2016',0);
  echo json_encode(json_decode($events,true),JSON_PRETTY_PRINT);
  
  
  
  echo '<br/> getEventsbyWeek: 03-22-2016 <br/>';
  $events = $DatabaseConnection->getEventsbyWeek('03-22-2016',1);
  echo json_encode(json_decode($events,true),JSON_PRETTY_PRINT);
  $DatabaseConnection->disconnect();

?>
