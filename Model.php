
<?php
  
  class User{
	  	    
          private $name;
		      private $UserID;
		      private $Role;
		      public $UserName;
		      public $Password;
		     
         function __construct($userName, $Password){                          
			      $this->userName = $userName;
			      $this->Password = hash("sha256", $Password);;
		      }
                

	}
 
 
   class Event{
     
       public $ID;
       public $Title;
       public $startDate;
       public $EndDate;
       public $startTime;
       public $EndTime;
       public $Place;
       public $Submitter;
       public $UserID;
       public $Organization;
       public $EventName;
       public $Image;
       public $link;
       public $Description;
       public $Approved;
       
       function __construct($ID,$Title,$startDate,$EndDate,$startTime,$endDate,$Place,$Submitter,$UserID,$Organization,$Eventname,$Image,$link,$Description,$Approved)
       {
         $this->ID = $ID;
         $this->Title = $Title;
         $this->startDate = $startDate;
         $this->EndDate = $EndDate;
         $this->startTime = $startTime;
         $this->EndTime = $endDate;
         $this->Place = $Place;
         $this->Submitter = $Submitter;
         $this->UserID = $UserID;
         $thi->Organization = $Organization;
         $this->EventName = $Eventname;
         $this->Image = $Image;
         $this->link = $link;
         $this->Description = $Description;
         $this->Approved = $Approved;
       }
       
   
   }

	#$user = new User('cls33','12345');
#	echo $user->userName;
#	echo '<br/>';
#	echo $user->Password;
?>
