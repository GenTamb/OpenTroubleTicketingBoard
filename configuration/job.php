<?php
require_once "../function/funcs.php";

//setting up DataBase 
if(isset($_POST['configureDB']))
{
$dbName=sanitizeInput($_POST['dbName']);
$host=sanitizeInput($_POST['host']);
$user=sanitizeInput($_POST['user']);
$psw=sanitizeInput($_POST['psw']);
//all input sanitized by sanitizedInput function


//creating connection
$connection=new mysqli($host,$user,$psw);
if($connection->connect_error)
{
    echoResponse('no',$connection->connect_error);
}


//creating DB
$createDB="CREATE DATABASE IF NOT EXISTS $dbName CHARACTER SET utf8 COLLATE utf8_general_ci";
if($connection->query($createDB))
{
    echoResponse('yes',"DB $dbName created successfully!");
}
else 
{
    echoResponse('no',$connection->error);
 
}

$connection->close();

//generating db.php file for future connections

if($configFile=fopen("db.php","w"))
{
    $txt="<?php

/*
 *---------------------------------------------------*
 *-          here are set your DB specs             -*
 *-  this file is generated automatically by the    -*
 *-         db creation with form submit            -*
 *---------------------------------------------------*/

define('DB','$dbName');
define('HOST','$host');
define('USER','$user');
define('PSW','$psw');

?>
";
fwrite($configFile,$txt);
fclose($configFile);
}
else echoResponse('no',"Unable to create config.php!\nCheck your permission on disk");
}

//setting up Admin user
if(isset($_POST['configureAdmin']))
{
    //requiring the db.php file just created
    require_once "db.php";
    $adminUserName=sanitizeInput($_POST['adminUserName']);
    $adminName=sanitizeInput($_POST['adminName']);
    $adminSurName=sanitizeInput($_POST['adminSurName']);
    $adminPassword=sanitizeInput($_POST['adminPassword']);
    
    //salting password
    $saltedPassword=salting($adminPassword);
    $connection=new mysqli(HOST,USER,PSW,DB);
    if($connection->connect_error)
    {
        echoResponse('no',$connection->connect_error);
    }
    
    //creating table users
    $createTable="CREATE TABLE IF NOT EXISTS users
    (username varchar(20),
    name varchar(15),
    surname varchar(15),
    position ENUM('admin','superuser','user'),
    password varchar(200),
    INDEX(username(20)),
    INDEX(name(15)),
    INDEX(surname(15)),
    PRIMARY KEY (username)) ENGINE InnoDB";
    if(!$connection->query($createTable))
    {
        echoResponse('no',$connection->error);
    }
    //adding Admin
    $addAdmin="INSERT INTO users (username,name,surname,position,password) VALUES ('$adminUserName','$adminName','$adminSurName','admin','$adminPassword')";
    if($connection->query($addAdmin))
    {
        echoResponse('yes','Admin and users table correctly created!');
    }
    else echoResponse('no',$connection->error);
    
    $connection->close();
}

//setting up Board name
if(isset($_POST['configureBoard']))
{
    
 require_once "db.php";
 $boardName=sanitizeInput($_POST['boardName']);
 $organizationName=sanitizeInput($_POST['organizationName']);
 
 $connection=new mysqli(HOST,USER,PSW,DB);
    if($connection->connect_error)
    {
        echoResponse('no',$connection->connect_error);
    }
 
 //set a new table to store this info, it should contain just 1 record..
 $addBoardTable="CREATE TABLE board
 (boardName varchar(20),
 organizationName varchar(30),
 PRIMARY KEY(boardName)) ENGINE InnoDB";
 
 if(!$connection->query($addBoardTable))
    {
        echoResponse('no',$connection->error);
    }
    //adding board's data
    $addBoardDetails="INSERT INTO board (boardName,organizationName) VALUES ('$boardName','$organizationName')";
    if($connection->query($addBoardDetails))
    {
        echoResponse('yes',"Your board $boardName has been correctly created!");
    }
    else echoResponse('no',$connection->error);
    
    $connection->close();
}



?>