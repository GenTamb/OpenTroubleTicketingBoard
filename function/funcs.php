<?php
function sanitizeInput($string) //sanitize your inputs
{
    $string= strip_tags($string);
    $string= htmlentities($string);
    $string= stripslashes($string);
    $string=mysql_real_escape_string($string); //to replace with undeprecated one
    return $string;
}

function echoResponse($stat,$resp)   //send an echo to the calling page: parameters are 'yes' or 'no' plus a message of your choice
{
    $status[]=$stat;
    $status[]=$resp;
    echo json_encode($status);
    if($stat=='no') die();          //if 'no', end script
}

function salting($password,$salt,$pepper) //just return a salted token
{
    $token=$salt.$password.$pepper;
    $token=hash('ripemd128',"$token");
    return $token;
}

function doAlert($message)
{
    echo "<script>alert('$message');</script>";
}

function checkInstallation()
{
    if(!file_exists('configuration/db.php'))
    {
       doAlert('Configuration file missing!\nHave you done the setup procedure?');
       if(file_exists('setup.php'))
       {
          header('Location:setup.php');
       }
       else doAlert('Your installation is compromised!\nPlease, restart setup or contact support');
    }
    else return true;
}

function getBoardName()
{
    
    $boardName;
    $res;
    $connection= new mysqli(HOST,USER,PSW,DB);
    $query="SELECT boardName FROM board WHERE 1";
    if(!$res=$connection->query($query)) die('error'.$connection->connect_errno);
    else
    {
        $row=$res->fetch_assoc();
        $boardName=$row['boardName'];
        $connection->close();
        return $boardName;
    }
    
}
function getOrgName()
{
    
    $boardName;
    $res;
    $connection= new mysqli(HOST,USER,PSW,DB);
    $query="SELECT organizationName FROM board WHERE 1";
    if(!$res=$connection->query($query)) die('error'.$connection->connect_errno);
    else
    {
        $row=$res->fetch_assoc();
        $boardName=$row['organizationName'];
        $connection->close();
        return $boardName;
    }
    
}

function checkLogin()
{
    if(include_once ('db.php'))
    {
        $loginPath=ROOT."login.php";
    }
    else if(include_once ('../configuration/db.php'))
            {
                $loginPath="../login.php";
            }
    else $loginPath='login.php';
    
    if(!isset($_SESSION['logged']))
    {
        //doAlert('Not even logged!');
        header("Location:login.php");
    }
    else if($_SESSION['logged']!=1)
    {
        //doAlert('Something gone wrong with your login');
        
        header("Location:$loginPath");
    }
    else if($_SESSION['logged']==1)
    {
     return true;
    }
}

function setupUser($user)
{
    
    $user->setUsername($_SESSION['username']);
    $user->setName($_SESSION['name']);
    $user->setSurname($_SESSION['surname']);
    $user->setPosition($_SESSION['position']);
}

//check first setup
function checkFirstSetup()
{
  include_once 'db.php';                     //include this
  include_once '../configuration/db.php';   // or this..
  $response;
  $connection=new mysqli(HOST,USER,PSW,DB);
  $query='SELECT * FROM board WHERE 1';
  $res=$connection->query($query);
  if(!$res) die('error'.$connection->error);
  else
    {
        $fields=$res->field_count;
        if($fields==2)  $response=true;
        else $response=false;
    }
 $res->close();
 $connection->close();
 return $response;
}

function addGroupName($name)
{
    include_once '../configuration/db.php';
    include_once 'db.php';
    $name=sanitizeInput($name);
    $addGroupQuery="CREATE TABLE $name
                      (username varchar(20),
                       name varchar(15),
                       surname varchar(15),
                       INDEX(username(20)),
                       INDEX(name(15)),
                       INDEX(surname(15)),
                       PRIMARY KEY(username)) ENGINE InnoDB";
    $connection=new mysqli(HOST,USER,PSW,DB);
    $execute=$connection->query($addGroupQuery);
    if(!$execute) die('error doing query');
    else
    {
        
        $connection->close();
        return true;
    }
}

function getAdminUsername() //this works only for the first admin
{
    include_once '../configuration/db.php';
    include_once 'db.php';
    $connection=new mysqli(HOST,USER,PSW,DB);
    $query="SELECT username FROM users WHERE 1"; //it returns only 1 result
    if(!$res=$connection->query($query)) die('error'.$connection->connect_errno);
    else
    {
        $row=$res->fetch_assoc();
        $username=$row['username'];
        $connection->close();
        return $username;
    }
}

?>