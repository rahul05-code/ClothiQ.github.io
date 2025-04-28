<!-- 1. create database auth;

2. create table users(
    id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255) NOT NULL,
    email VARCHAR(255)NOT NULL UNIQUE, password VARCHAR(255)NOT NULL,
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); -->

<?php 
$host="localhost";
$username="root";
$password="";
$dbname="project1";

$con = new mysqli($host,$username,$password,$dbname);

if($con->connect_error){
    die("Connection Falied".$con->connect_error);
}else{
    //echo "Connection Successful !";
}



?>