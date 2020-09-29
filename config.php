<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "ajax";

$conn = new mysqli($host,$username,$password,$database);

if($conn->connect_error){
    die("Could not connect to database:".$conn->connect_error);
}