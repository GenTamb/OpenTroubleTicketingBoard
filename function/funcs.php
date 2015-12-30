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
    require_once 'configuration/db.php';
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
    require_once 'configuration/db.php';
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
?>