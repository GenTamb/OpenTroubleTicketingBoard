<?php
require_once '../configuration/db.php';
require_once '../function/funcs.php';

$username=sanitizeInput($_POST['username']);
$password=sanitizeInput($_POST['password']);

$password=salting($password,SALT,PEPPER);

$connection=new mysqli(HOST,USER,PSW,DB);

if($connection->connect_error)
{
    echo $connection->connect_error;
    die('error'.$connection->connect_error);
}
else
{
    $query="SELECT * FROM users WHERE username='$username' AND password='$password'";
    $check=$connection->query($query);
    if(!$check) die($connection->error);
    $row=$check->num_rows;
    
    if($row==1)
    {
        $res=$check->fetch_assoc();
        session_start();
        $_SESSION['logged']=1;
        $_SESSION['username']=$res['username'];
        $_SESSION['name']=$res['name'];
        $_SESSION['surname']=$res['surname'];
        $_SESSION['position']=$res['position'];
        $answer=array(1,$res['name'],$res['surname']);
        echo json_encode($answer);
    }
    else
    {
        $answer[0]=0;
        echo json_encode($answer);
}
}
?>
