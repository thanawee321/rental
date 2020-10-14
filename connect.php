<?php 
$host = "localhost";
$user="root";
$password = "";
$database = "rental";

$connect = mysqli_connect($host,$user,$password,$database) or die ("Error\nConnection DataBase" . mysqli_error($connect));
//mysqli_character_set_name("utf-8");

?>