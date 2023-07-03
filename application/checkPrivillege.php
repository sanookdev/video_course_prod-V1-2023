<?php 

$user = "software_001"; 
$password = "fkoVXT8H1<UqruS"; 
$host = "192.168.66.18"; 



$connection= mysqli_connect($host, $user, $password);
if (!$connection)
{
die ('Could not connect:' . mysqli_error());
}

$result= mysqli_query($connection,"SHOW GRANTS FOR username");
$row = mysqli_fetch_array($result);
print_r($row);
// while($row=mysqli_fetch_array($result)){
//     print_r($row);
// } 

?>