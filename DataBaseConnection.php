<?php
 # $host = "sql2.njit.edu";
 # $user = "cls33";
 # $password = "J2nf0VWWc";
 # $database = "cls33";
  
  include_once('Model.php');
  
  /**
   * Created by Cesar Salazar
   * Database conection managemen class
   **/
  class DatabaseConnection{
  
    private $host;
    private $user;
    private $password;
    private $database;
    private $connection;
    function __construct()
    {
      $this->host = 'sql2.njit.edu';
      $this->user = 'cls33';
      $this->password = 'J2nf0VWWc';
      $this->database = 'cls33';
      
      $this->connect();
    }
    
    private function connect()
    {
       $this->connection = mysqli_connect($this->host, $this->user,$this->password,$this->database);#mysqli_connect('sql2.njit.edu','cls33','J2nf0VWWc','cls33');
    }
    
    public function disconnect()
    {
      if($this->connection)
        mysqli_close($this->connection);
    }
    
    /**
     * CHeck if the given user is a valid login 
     **/
    public function checkLogin($User)
    {
    
      $query = "select UserID, Role from `User` as u inner join `Role` as r on u.UserID = r.RoleID where UserName = '".$User->userName."' and Password = '".$User->Password."'";
        
      $result = mysqli_query($this->connection,$query);
      
      if(!$result)
      {
       # echo $this->connection;
          print( mysqli_error($this->connection));
          return json_encode(array('UserID'=> "-2", 'Role'=> "-2"));
      }
      else
      {
          if(mysqli_num_rows($result) > 0)
          {
              return json_encode(mysqli_fetch_object($result),true);
          }
          else
          {
              return json_encode(array('UserID' => "-1", 'Role'=> "-1"));
          }
      
      
      }
    
    }

    /**
     * Get Role of the Given UserID
     **/
    public function getRole($UserId)
    {
    	$query = "Select Role from `User` where UserID = '".$UserId."'";
    	#echo "<br/>";
    	#echo $query."<br/>";
    	$result = mysqli_query($this->connection,$query);
    
    	if(!$result)
    	{
    		print(mysqli_error($this->connection));
    		return json_encode(array('Role'=>"-2"));
    	}
    	else
    	{
    		if(mysqli_num_rows($result) > 0)
    		{
    			return json_encode(mysqli_fetch_object($result),true);
    		}
      	else
      	{
    			return json_encode(array('Role'=> "-1"));
    		
    		}
    	
    	}

       #return  'UserID: '.$UserId;
    }
    
    
    /**
     * Checks if the event exist in the data base
     * This method is used only for the events gotten 
     * from NJIT page
     **/
    public function EventExist($Event)
    {
      $query = "select * from `Events` where Title = '".$Event->Title."' and startDate = '".$Event->startDate."' and EndDate = '".$Event->EndDate."' and Submitter = '".$Event->Submitter." ' and startTime = '".date("H:i", strtotime($Event->startTime))."'  and endTime = '".date("H:i", strtotime($Event->EndTime))."'";
      
      
      #echo $query;
      	$result = mysqli_query($this->connection,$query);
    
    	if(!$result)
    	{
    		return -1;
    	}
    	else
    	{
    		if(mysqli_num_rows($result) > 0)
    		{
    			return 1;
    		}
    		else
    		{
    			return 0;
    		
    		}
    	
    	}
      
    }
    
    /**
     * Inserts Event into the data bse
     **/
    public function insertEvent($Event)
    {
    
      if(!is_null($Event->UserID))
      {
        $query = "insert into `Events` (ID, Title, Submitter, startTime, startDate, Place, Organization, link, Image, EventName, endTime, EndDate, Description, Approved, UserID) Values (".$Event->ID.", '".$Event->Title." ', '".$Event->Submitter." ', TIME '".date("H:i", strtotime($Event->startTime))."' , DATE '".$Event->startDate."', '".$Event->Place." ', '".$Event->Organization." ', '".$Event->link." ', '".$Event->Image." ', '".$Event->EventName." ', '".date("H:i", strtotime($Event->EndTime))."', DATE '".$Event->EndDate."', '".$Event->Description." ', ".$Event->Approved.", ".$Event->UserID.")";
      }
      else
      {
        $query = "insert into `Events` (ID, Title, Submitter, startTime, startDate, Place, Organization, link, Image, EventName, endTime, EndDate, Description, Approved) Values (".$Event->ID.", '".$Event->Title." ', '".$Event->Submitter." ', TIME '".date("H:i", strtotime($Event->startTime))."' , DATE '".$Event->startDate."', '".$Event->Place." ', '".$Event->Organization." ', '".$Event->link." ', '".$Event->Image." ', '".$Event->EventName." ', '".date("H:i", strtotime($Event->EndTime))."', DATE '".$Event->EndDate."', '".$Event->Description." ', ".$Event->Approved.")";
      }
    
        # echo $query;
        #mysql_insert_id()
      if (mysqli_query($this->connection,$query) === TRUE) {
          $lastID = mysqli_insert_id($this->connection);
          #  echo "Inserted ".$lastID;
        echo json_encode(array('EventID'=> $lastID));
      } else {
          #      echo 'Error';
        echo json_encode(array('EventID'=> -1));
      }
    
    }
    
    /**
     * Gets Event by Date and the approval status
     **/
    public function getEventsbyDate($date,$Approved)
    {
    
      $query = "select * from `Events` where startDate >= DATE '".$date."' and Approved = ".$Approved."";
        
      #echo $query;
      $result = mysqli_query($this->connection,$query);
      
      if(!$result)
      {
       # echo $this->connection;
          print( mysqli_error($this->connection));
          return json_encode(array('Error'=> "-2"));
      }
      else
      {
          if(mysqli_num_rows($result) > 0)
          {
              $rows = array();
              for ($i=0;$i<mysqli_num_rows($result);$i++) {
                #echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
                $rows[] = mysqli_fetch_object($result);
             }
             
             return json_encode(array('Events' => $rows));
          }
          else
          {
              return json_encode(array('Error' => "-1"));
          }
      
      
      }
    
    }
    

    /**
     * Delete Event By Week based on the given date and the approve status 
     **/
    public function getEventsbyWeek($date,$Approved)
    {

      $query = "select e.* from Events e cross join (select min(startDate) as nextdate from Events where startDate >= Date '".$date."' and Approved = ".$Approved.") em where e.startDate between em.nextdate and date_add(em.nextdate, interval 1 week) and Approved = ".$Approved.";";
        
      
#echo $query;
    $result = mysqli_query($this->connection,$query);
      
      if(!$result)
      {
       # echo $this->connection;
          print( mysqli_error($this->connection));
          return json_encode(array('Error'=> "-2"));
      }
      else
      {
          if(mysqli_num_rows($result) > 0)
          {
              $rows = array();
              for ($i=0;$i<mysqli_num_rows($result);$i++) {
                #echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
                $rows[] = mysqli_fetch_object($result);
             }
             
             return json_encode(array('Events' => $rows));
          }
          else
          {
              return json_encode(array('Events' => "-1"));
          }
      
      
      }
    
    }
    
    
    public function getEvents($date)
    {
    
      $query = "select e.* from Events e cross join (select min(startDate) as nextdate from Events where startDate >= Date '".$date."') em where e.startDate between em.nextdate and date_add(em.nextdate, interval 1 week);";
        
      
      
    $result = mysqli_query($this->connection,$query);
      
      if(!$result)
      {
       # echo $this->connection;
          print( mysqli_error($this->connection));
          return json_encode(array('Error'=> "-2"));
      }
      else
      {
          if(mysqli_num_rows($result) > 0)
          {
              $rows = array();
              for ($i=0;$i<mysqli_num_rows($result);$i++) {
                #echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
                $rows[] = mysqli_fetch_object($result);
             }
             
             return json_encode(array('Events' => $rows));
          }
          else
          {
              return json_encode(array('Error' => "-1"));
          }
      
      
      }
    
    }
    
    /**
     * Delete Event By ID
     **/
    public function DeleteEvent($ID)
    {
    
    $query = "delete from `Events` where ID = ".$ID.";";
    
  
      if ($this->connection->query($query) === TRUE) {
        echo "Record Deleted successfully";
      } else {
        echo "Error: " . $query . "<br>" . $this->connection->error;
      }
    
    }
    
    /**
     * Gets Event By ID
     **/
    public function getEventByID($ID)
    {
    
      $query = "select * from `Events` where ID = ".$ID.";";
      #echo $query;
  
      $result = mysqli_query($this->connection,$query);
      
      if(!$result)
      {
       # echo $this->connection;
          print( mysqli_error($this->connection));
          return json_encode(array('Error'=> "-2"));
      }
      else
      {
          if(mysqli_num_rows($result) > 0)
          {
              return json_encode(array('Event' => mysqli_fetch_object($result)));
          }
          else
          {
              return json_encode(array('Event' => "-1"));
          }
      
      
      }
    
    }
  }
    
    
    
?>
