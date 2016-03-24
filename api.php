<?php

#var_dump($_POST);
#Gettin from JSON
#$request = file_get_contents('php://input');
#echo $request;
#$input = json_decode($request,true);
#$userName = $input['username'];
#$password = $input['Password'];
#echo $input;
#echo '<br/>';
#echo 'UserName: '.$input['userName'];
#echo '<br/>';
#echo 'Password: '.$input['Password'];
#Geting from form
# Receive credentials information
$username = $_POST['userName'];
$Password = $_POST['Password'];
#var_dump($_POST);


#echo $data;
#echo $username;
#echo '<br/>';
#echo $Password;
#echo '<br/>';

#Hash password
$Hashed =  hash("sha256", $Password);
#echo $Hashed;


#connect to SQL
$conn = mysqli_connect('sql2.njit.edu','cls33','J2nf0VWWc','cls33');

#SQL Query 
$query = "select UserID from `User` where UserName = '".$username."' and Password = '".$Hashed."'";


#echo $query;
#consult data base
$result = mysqli_query($conn,$query);
#echo '<br/>';
if(!$result)
{
    echo json_encode(array('UserID'=> "-2"));
}
else
{
    if(mysqli_num_rows($result) > 0)
    {
        for ($i=0;$i<mysqli_num_rows($result);$i++) {
                echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
             }
    }
    else
    {
        echo json_encode(array('UserID' => "-1"));
    }


}

#close connection to SQL
mysqli_close($conn);

?>
