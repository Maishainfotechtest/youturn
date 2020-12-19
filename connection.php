<?php 
$host = "localhost";
$server = "root";
$password = "";
$databse = "youturn";

$conn = mysqli_connect($host,$server,$password,$databse);
if($conn){
    echo " ";
}
else{
    echo "connection failed";
}
?>