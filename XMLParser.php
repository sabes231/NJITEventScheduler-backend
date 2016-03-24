<?php
	#include_once('Model.php');

	#$user = new User('cls33','12345');

	#echo $user->userName;
	#echo '<br/>';
	#echo $user->Password;
	#echo '<br/>';
 #ini_set('display_errors', 'On');
 #error_reporting(E_ALL);
	
  include_once('DataBaseConnection.php'); 
 
	#echo 'Xml Parser';

	$xmlUrl = "http://25livepub.collegenet.com/calendars/NJIT_EVENTS.rss";
	#$xml_data = file_get_contents($xmlUrl);
	#$xml_data = simplexml_load_string($xmlUrl);
	
	$xml = new SimpleXMLElement(file_get_contents($xmlUrl));

	echo "<br/>";
	
	$channel = $xml-> {'channel'};
	


	foreach( $channel->{'item'} as $item ) {
	
 	   
	   $Description = explode ("<br/>",$item->description);
	   $i = 0;
	   $eventname ="";
	   $Date ="";
	   $Place = "";
	   $Organization = "";
	   $Submitter = "";
	   $image = "";
	   $description = "";
	   foreach($Description as $val)
	   {
	   	if($i == 0)
	  	{
			$Place = $val;
		}
		else if($i == 1)
		{
		 	 $Date = $val;;
		}
		else
		{
			
			$pos = strrpos($val,"<b>Event Name</b>:&nbsp;");
			if($pos !==false)
			{
				$eventname = substr($val,$pos+24);
				continue;
			}

			$pos = strrpos($val,"<b>Organization</b>:&nbsp;");
			
			if($pos !== false)
			{
				$Organization = substr($val,26);
				continue;
			}

			$pos = strrpos($val,"<b>Submitter Name</b>:&nbsp;");
			                        
			if($pos !== false)
			{
	                  	$Submitter = substr($val,28);     
	                        continue;
	                }  
			
			$pos = strrpos($val,"<img ");

			if($pos !== false)
			{
				$image = $val;
				continue;
			}
			
			if(strcmp($val,""))
			{
				$description = $val;
			}

		}
		$i++;
	   }
	 echo "<b>Description :</b> ". $description."<br/>";
	 echo "<b>Date : </b>".$Date."<br/>";
	 $SplitDate = explode (",",$Date);
	
	 if(count($SplitDate) == 6)
	 {
  	 	$WeekDay = $SplitDate[0];
  		$DateD = $SplitDate[1];
      #$SplitDate = explode ("&nbsp;&ndash;&nbsp;",$Time);
      $startDate = $SplitDate[1].",".$SplitDate[4];
      $EndDate = $SplitDate[3].",".$SplitDate[4];
      
      $splitTime = explode ("&nbsp;&ndash;",$SplitDate[2]);
      $t ="";
  			
        if(strrpos($splitTime[0],"pm"))
  			{
  				$t = "pm";
  			}
  			else
  			{
  				$t = "am";
  			}
  			if(strlen($splitTime[0]) == 4 )# ' 1am'
  			{
  				$startTime = substr($splitTime[0],1,1).":00 ".$t;
  			}
  			else if(strlen($splitTime[0]) == 5 )# ' 12am'
  			{
  				$startTime = substr($splitTime[0],1,2).":00 ".$t;	
  			}
  			else if(strlen($splitTime[0]) == 7 )#' 1:00am' 
  			{
  				$startTime = substr($splitTime[0],1,4)." ".$t; 
  			}
  			else if(strlen($splitTime[0]) >= 8 )#' 12:00am'
  			{
  				$startTime = substr($splitTime[0],1,5)." ".$t;
  			}
  			else
  			{
  				$startTime = $splitTime[0];	
  			}
        
        $t = "";
  		if(strrpos($SplitDate[5],"am"))
  		{
  			$t = "am";
  		}
  		else
  		{
  			$t = "pm";
  		}
  
  		if(strlen($SplitDate[5]) == 4)//9am
  		{
  			$endTime = substr($SplitDate[5],1,1).":00 ".$t;
  		}
  		else if(strlen($SplitDate[5]) == 5)//12am
  		{
  			$endTime = substr($SplitDate[5],1,2).":00 ".$t;
  		}
  		else if(strlen($SplitDate[5]) == 7)//1:00pm
  		{
  			$endTime = substr($SplitDate[5],1,4)." ".$t;
  		}
  		else if(strlen($SplitDate[5]) >= 8 )//12:00am //12:00pm
  		{
  			$endTime = substr($SplitDate[5],1,5)." ".$t;
  		}
  		else
  		{
  			$endTime = $SplitDate[5].":00 ".$t;
  		}
	 }
	 else
	 {
	 	$WeekDay = $SplitDate[0];
	 	$DateD = $SplitDate[1];
	 	$Year = $SplitDate[2];
	 	$Time = $SplitDate[3];
          
    $startDate = $DateD.",".$Year;
    $EndDate = $DateD.",".$Year;

	 	$splitTime = explode ("&nbsp;&ndash;&nbsp;",$Time);
		
    
    if(strrpos($splitTime[0],"am") or strrpos($splitTime[0],"pm"))
		{
  			$t ="";
  			if(strrpos($splitTime[0],"pm"))
  			{
  				$t = "pm";
  			}
  			else
  			{
  				$t = "am";
  			}
  			if(strlen($splitTime[0]) == 4 )# ' 1am'
  			{
  				$startTime = substr($splitTime[0],1,1).":00 ".$t;
  			}
  			else if(strlen($splitTime[0]) == 5 )# ' 12am'
  			{
  				$startTime = substr($splitTime[0],1,2).":00 ".$t;	
  			}
  			else if(strlen($splitTime[0]) == 7 )#' 1:00am' 
  			{
  				$startTime = substr($splitTime[0],1,4)." ".$t; 
  			}
  			else if(strlen($splitTime[0]) >= 8 )#' 12:00am'
  			{
  				$startTime = substr($splitTime[0],1,5)." ".$t;
  			}
  			else
  			{
  				$startTime = $splitTime[0];	
  			}
		}
		else
		{
  			$t = "";
  			if(strrpos($splitTime[1],"am"))
  			{
  				$t = "am";
  			}
  			else
  			{
  				$t = "pm";
  			}
  				
  			if(strlen($splitTime[0]) == 5)#' 1:30'
  			{
  				$startTime = substr($splitTime[0],1,4)." ".$t;
  			}
  			else if(strlen($splitTime[0]) == 6)#' 12:30'
  			{
  				$startTime = substr($splitTime[0],1,5)." ".$t;	
  			}
  			else
  			{
  				$startTime = $splitTime[0].":00 ".$t;	
  			}
		}
		
		$t = "";
		if(strrpos($splitTime[1],"am"))
		{
			$t = "am";
		}
		else
		{
			$t = "pm";
		}

		if(strlen($splitTime[1]) == 4)//9am
		{
			$endTime = substr($splitTime[1],0,1).":00 ".$t;
		}
		else if(strlen($splitTime[1]) == 5)//12am
		{
			$endTime = substr($splitTime[1],0,2).":00 ".$t;
		}
		else if(strlen($splitTime[1]) == 7)//1:00pm
		{
			$endTime = substr($splitTime[1],0,4)." ".$t;
		}
		else if(strlen($splitTime[1]) >= 8 )//12:00am //12:00pm
		{
			$endTime = substr($splitTime[1],0,5)." ".$t;
		}
		else
		{
			$endTime = $splitTime[1].":00 ".$t;
		}
		
		
		
		

		#echo "<b>End Time : </b>".$splitTime[1]."<br/>";
		
	}
   echo "<b>Title:</b> ".$item->title . "<br />\n";
   echo "<b>StartDate : </b>".$startDate."<br/>";
   echo "<b>EndDate : </b>".$EndDate."<br/>";
   echo "<b>WeekDay : </b>".$WeekDay."<br/>";
   #echo "<b>Dated : </b>".$DateD."<br/>";
	# echo "<b>Year</b>".$Year."<br/>";
 #	 echo "<b>Time</b>".$Time."<br/>";
	 echo "<b>Start Time : </b>".$startTime."<br/>";
	 echo "<b>End Time : </b>".$endTime."<br/>";
	 echo "<b>Place : </b>".$Place."<br/>";
	 echo "<b>Submitter : </b>".$Submitter."<br/>";
	 echo "<b>Organization</b> : ".$Organization."<br/>";
	 echo "<b>Event Name : </b>".$eventname."<br/>";
	 echo "<b>Image :</b>".$image."<br/>";
	 echo "<b>link:</b> ".$item->link . "<br />\n";
   
   //($ID,$Title,$startDate,$EndDate,$startTime,$endDate,$Place,$Submitter,$UserID,$Organization,$Eventname,$Image,$link,$Description)
   $Event = new Event(0,$item->title,date("Y-m-d",strtotime($startDate)),date("Y-m-d", strtotime($EndDate)), $startTime, $endTime, $Place, $Submitter, NULL, $Organization, $eventname, $image, $item->link, $description,'TRUE' );
   
   $DatabaseConnection = new DataBaseConnection();
   
   $Exist = $DatabaseConnection->EventExist($Event);
 #  echo $$Exist;
   if($Exist <= 0)
   {
     $DatabaseConnection->insertEvent($Event); 
     echo "Inserted<br/>";
   }
   else
   {
     echo "Skip<br/>";
   }
  // $DatabaseConnection->insertEvent($Event);     
	 
   echo "<br/>";
   echo "----------------------------------------------------------<br/>";	 
# echo "<b>link:</b> ".$item->link . "<br />\n";"	
	}
##print_r($xml);

?>
