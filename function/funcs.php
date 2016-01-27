<?php
function sanitizeInput($string) //sanitize your inputs
{
    $string= strip_tags($string);
    $string= htmlentities($string);
    $string= stripslashes($string);
    //$string=mysql_real_escape_string($string); //to replace with undeprecated one
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
        $loginPath=ROOT."/login.php";
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
    include_once ('../configuration/ClassUser.php');
    $user->setUsername($_SESSION['username']);
    $user->setName($_SESSION['name']);
    $user->setSurname($_SESSION['surname']);
    $user->setPosition($_SESSION['position']);
    $user->setGroup($_SESSION['groupName']);
}

function checkUserAdminOrSuperUser($user)
{
    include_once ('../configuration/ClassUser.php');
    ($user->getPosition()=='admin' || $user->getPosition()=='superuser') ? $res=true : $res=false;
    return $res;
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
    $addGroupQuery="CREATE TABLE IF NOT EXISTS $name
                      (username varchar(20),
                       name varchar(15),
                       surname varchar(15),
                       mail varchar(50),
                       phone varchar(20),
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
        /*$path=ROOT."/configuration/db.php";   experimental
        $appendFile=fopen("$path","a");
        $text="<?php define('$name','$name');?>";
        fwrite($appendFile,$text);
        fclose();*/ 
        return true;
    }
}

/*function addGroup($tableName,$username,$length1,$name,$length2,$surname,$length3)   experimental
{
    include_once '../configuration/db.php';
    include_once 'db.php';
    $numArgs=func_get_args();
    foreach($numArgs as $arg) $arg=sanitizeInput($arg);  //sanitizing all inputs
    if(is_numeric($length1) && is_numeric($length2) && is_numeric($length3))
    {
     $addGroupQuery="CREATE TABLE IF NOT EXISTS".$tableName."
                     ($username   
     "
    }
    
    
}*/

function getAdminData($admin) //this is used first time to get the one and only admin, later, can be reused, maybe
{
    include_once '../configuration/db.php';
    include_once 'db.php';
    $connection=new mysqli(HOST,USER,PSW,DB);
    $query="SELECT username,name,surname FROM users WHERE position='$admin'"; //it returns only 1 result
    if(!$res=$connection->query($query)) die('error'.$connection->connect_errno);
    else
    {
        while($row=$res->fetch_assoc())
        {
        $data[]=$row['username'];
        $data[]=$row['name'];
        $data[]=$row['surname'];
        }
        $connection->close();
        return $data;
    }
}

function seedTableList($name,$type)
{
    include_once '../configuration/db.php';
    include_once 'db.php';
    $numArgs=func_get_args();
    foreach($numArgs as $arg) $arg=sanitizeInput($arg);  //sanitizing all inputs
    $query="INSERT INTO tablelist (tabName,tabType) VALUES ('".$name."','".$type."')";
    $connection=new mysqli(HOST,USER,PSW,DB);
    if($res=$connection->query($query))
    {
        $response=true;
    }
    else $response=false;
    $connection->close();
    return $response;
}

function checkCustomerTable()
{
    include_once '../configuration/db.php';
    include_once 'db.php';
    $query="SELECT tabName FROM tableList WHERE tabType='customerTable'";
    $connection=new mysqli(HOST,USER,PSW,DB);
    $res=$connection->query($query);
    $count=$res->num_rows;
    if($count==1) $response=true;
    else $response=false;
    return $response;
}
/*  not used
function populateCustomerAssetField($assetCode,$customerID)
{
    include_once '../configuration/ClassAsset.php';
    include_once '../configuration/ClassCustomer.php';
    
    //declaring and populating asset and customer
    $asset=new Asset();
    $customer=new Customer();
    $asset->getAssetBy($assetCode);
    $customer->getCustomerBy($customerID);
    $response=null;
    //checking if code given is good, due to the behavior of getAssetBy function
    if($assetCode==$asset->code) return $customer->addAssetList($assetCode);
}

function dePopulateCustomerAssetField($assetCode,$customerID)
{
    include_once '../configuration/ClassAsset.php';
    include_once '../configuration/ClassCustomer.php';
    
    //declaring and populating asset and customer
    $asset=new Asset();
    $customer=new Customer();
    $asset->getAssetBy($assetCode);
    $customer->getCustomerBy($customerID);
    $response=null;
    //checking if code given is good, due to the behavior of getAssetBy function
    if($assetCode==$asset->code)
    {
        if($customer->delAssetList($assetCode)) //do the update
        {
            $response=true;
        }
        else $response=false;
    }
    return $response;
}
*/



?>