<?php
$host = "localhost";         
$user = "root";          
$pwd = "";              
$sql_db = "assessment_db"; 

$conn = mysqli_connect($host, $user, $pwd, $sql_db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}