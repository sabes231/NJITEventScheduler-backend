<?php

  include_once('DataBaseConnection.php');
  
  $UserID = $_POST['UserID'];
  $title = $_POST['title'];
  $startDate = $_POST['startDate'];
  $EndDate = $_POST['EndDate'];
  $startTime = $_POST['startTime'];
  $endTime = $_POST['endTime'];
  $Place = $_POST['Place'];
  $Submitter = $_POST['Submitter'];
  $Organization = $_POST['Organization'];
  $eventname = $_POST['eventname'];
  $image = $_POST['image'];
  $link = $_POST['link'];
  $description = $_POST['description'];
  $Approved = $_POST['Approved'];
  
  #echo $username;
  
  $DatabaseConnection = new DataBaseConnection();
  
  $Event = new Event(0,$title,date("Y-m-d",strtotime($startDate)),date("Y-m-d", strtotime($EndDate)), $startTime, $endTime, $Place, $Submitter, $UserID, $Organization, $eventname, $image, $link, $description,$Approved);
  
  
  $DatabaseConnection->insertEvent($Event);
  $DatabaseConnection->disconnect();

?>
