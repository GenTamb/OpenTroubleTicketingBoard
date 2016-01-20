<?php
include_once "../function/funcs.php";

//setting up DataBase 
if(isset($_POST['configureDB']))
{
include_once "../function/funcs.php";
session_start();
$dbName=sanitizeInput($_POST['dbName']);
$host=sanitizeInput($_POST['host']);
$user=sanitizeInput($_POST['user']);
$psw=sanitizeInput($_POST['psw']);
//all input sanitized by sanitizedInput function
$salt=$_POST['salt'];
$pepper=strrev($salt);
//salt is not sanitized, for now..

//creating connection
$connection=new mysqli($host,$user,$psw);
if($connection->connect_error)
{
    echoResponse('no',$connection->connect_error);
}


//creating DB
$createDB="CREATE DATABASE IF NOT EXISTS ".$dbName." CHARACTER SET utf8 COLLATE utf8_general_ci";
$exec=$connection->query($createDB);
if($exec)
{
    echoResponse('yes',"DB ".$dbName." created successfully!");
}
else 
{
    echoResponse('no',$connection->error);
 
}

$connection->close();

//generating db.php file for future connections

if($configFile=fopen("db.php","w"))
{
    $dirname=$_SESSION['root'];
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
define('SALT','$salt');
define('PEPPER','$pepper');
define('ROOT','$dirname');
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
    include_once "../configuration/db.php";
    $adminUserName=sanitizeInput($_POST['adminUserName']);
    $adminName=sanitizeInput($_POST['adminName']);
    $adminSurName=sanitizeInput($_POST['adminSurName']);
    $adminPassword=sanitizeInput($_POST['adminPassword']);

    
    //salting password
    $saltedPassword=salting($adminPassword,SALT,PEPPER);
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
    PRIMARY KEY (username)) DEFAULT CHARSET=utf8 ENGINE InnoDB";
    if(!$connection->query($createTable))
    {
        echoResponse('no',$connection->error);
    }
    //adding Admin
    $addAdmin="INSERT INTO users (username,name,surname,position,password) VALUES ('$adminUserName','$adminName','$adminSurName','admin','$saltedPassword')";
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
    
 require_once "../configuration/db.php";
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
 PRIMARY KEY(boardName)) DEFAULT CHARSET=utf8 ENGINE InnoDB";
 
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
//closing operations
if(isset($_POST['finishSetup']))  
   {
    require_once "db.php";
    if(!copy('../setup.php','../_installFolder/setup.php'))
    {
        echoResponse('no',"Error finishing setup: error copying files, check your permissions on disk!");
    }
    else
    {
        unlink('../setup.php');
        rename('../_installFolder/login.php','../login.php');
        rename('setupScript.js','../_installFolder/setupScript.js');
        rename('setupStyle.css','../_installFolder/setupStyle.css');
        rename('../_installFolder/board.php','../board.php');
        echoResponse('yes',"Yes! We did it!\nEnjoy your board!");
    }
   }

//login procedure   
if(isset($_POST['login']))
{
    require_once 'db.php';
    require_once ROOT.'/function/funcs.php';

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
           if(isset($res['groupName'])) $_SESSION['groupName']=$res['groupName']; //the first time login does not have groupName in table
           $answer=array(1,$res['name'],$res['surname']);
           echo json_encode($answer);
       }
       else
       {
           $answer[0]=0;
           echo json_encode($answer);
       }
       $connection->close();
   }
}

//setup step: adding first group
if(isset($_POST['addingFirstGroupName'])){
    include_once 'db.php';
    include_once '../function/funcs.php';
    
    if(checkFirstSetup())
    {
        $connection=new mysqli(HOST,USER,PSW,DB);
        if($connection->error) echoResponse('no',$connection->error);
        $addingField='ALTER TABLE board ADD firstSetup SMALLINT UNSIGNED';
        $added=$connection->query($addingField);
        if(!$added) echoResponse('no',$added->error);
        else
        {
            //echoResponse('yes','Field Added!');
            $settingFirstSetup="UPDATE board SET firstSetup='1' WHERE boardName='".getBoardName()."'";
            $settedFirstSetup=$connection->query($settingFirstSetup);
            if(!$settedFirstSetup) echoResponse('no',$settedFirstSetup->error);
            else
            {
                //echoResponse('yes','First Setup Done!');
                $remoteGroupName=sanitizeInput($_POST['remoteGroupName']);
                
                if(addGroupName($remoteGroupName))
                {
                    $addingField='ALTER TABLE users ADD groupName varchar(20)';
                    $added=$connection->query($addingField);                   //groupName added to users table
                    $data=getAdminData('admin');
                    $queryModifyAdmin="UPDATE users SET groupName='$remoteGroupName' WHERE username='".$data[0]."'";  //binding first admin to remote group
                    $executeModifyAdmin=$connection->query($queryModifyAdmin);
                    $seedingFirstGroup="INSERT INTO ".$remoteGroupName." (`username`, `name`, `surname`) VALUES ('".$data[0]."','".$data[1]."','".$data[2]."')"; //setting first admin in the remoteGroup
                    $seeded=$connection->query($seedingFirstGroup);
                    $createTableList="CREATE TABLE tablelist
                                      (tabName varchar(20),
                                       tabType varchar(20),
                                       INDEX(tabName(20)),
                                       PRIMARY KEY(tabName)) DEFAULT CHARSET=utf8 Engine InnoDB";
                    $executeCreateTableList=$connection->query($createTableList);
                    seedTableList($remoteGroupName,'remoteGroup');
                    seedTableList('board','services');
                    seedTableList('users','services');
                    $connection->close();
                    echoResponse('yes',"Table $remoteGroupName and tableList created and other tables modified successfully!");
                }
                else
                {
                  echoResponse('no','error creating table');
                }
            }
        }
        //echoResponse('yes','it works');
    }
    else
    {
        echoResponse('yes','First setup already done!');
    }

    
}

//setup step: adding customer table
if(isset($_POST['addingCTN']))
{
    include_once 'db.php';
    include_once '../function/funcs.php';
    $CTN=sanitizeInput($_POST['CTN']);
    $query="CREATE TABLE $CTN
            (id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
             name varchar(20) NOT NULL,
             surname varchar(30) NOT NULL,
             type varchar(20),
             site varchar(20),
             status ENUM('active','de-active'),
             assetList varchar(500),
             INDEX (name(20)),
             INDEX (surname(30))) DEFAULT CHARSET=utf8 ENGINE InnoDB";
    $connection=new mysqli(HOST,USER,PSW,DB);
    if($execute=$connection->query($query))
    {
        seedTableList($CTN,'customersTable');
        echoResponse('yes',"Table $CTN created successfully");
    }
    else echoResponse('no','Something went wrong');
    $connection->close();
    
}

//setup step: complete
if(isset($_POST['completeSetup']))
{
    include_once 'db.php';
    include_once '../function/funcs.php';
    //create table assets
    $createAssetsTable="CREATE TABLE IF NOT EXISTS assets
                        (code varchar(20) NOT NULL,
                         type varchar(20) NOT NULL,
                         ip varchar(20),
                         brand varchar(20),
                         model varchar(20),
                         site varchar(20),
                         status ENUM('active','de-active'),
                         assignee int(6),
                         INDEX(code(20)),
                         INDEX(brand(20)),
                         INDEX(model(20)),
                         INDEX(ip(20)),
                         PRIMARY KEY(code)) DEFAULT CHARSET=utf8 ENGINE InnoDB";
    $connection=new mysqli(HOST,USER,PSW,DB);
    if($execQuery=$connection->query($createAssetsTable)) seedTableList('assets','services');
    else echoResponse('no',$connection->error);
    //create table sites
    $createSitesTable="CREATE TABLE IF NOT EXISTS sites
                       (name varchar(30),
                        street varchar(100),
                        INDEX(name(30)),
                        INDEX(street(50)),
                        PRIMARY KEY(name)) DEFAULT CHARSET=utf8 ENGINE InnoDB";
    if($execQuery=$connection->query($createSitesTable)) seedTableList('sites','services');
    else echoResponse('no',$connection->error);
    //create table messages
    $createMessageTable="CREATE TABLE IF NOT EXISTS messages
                         (id int(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                          sender varchar(20),
                          target varchar(20),
                          body varchar(500)) DEFAULT CHARSET=utf8 ENGINE InnoDB";
    if($execQuery=$connection->query($createMessageTable)) seedTableList('messages','services');
    else echoResponse('no',$connection->error);
    //create table tickets
    $createSitesTable="CREATE TABLE IF NOT EXISTS tickets
                       (id int(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        asset varchar(20) NOT NULL,
                        status ENUM('open','working','pause','close') NOT NULL,
                        category varchar(50) NOT NULL,
                        customerName varchar(20) NOT NULL,
                        customerSurname varchar(30) NOT NULL,
                        site varchar(20) NOT NULL,
                        openedBy varchar(20) NOT NULL,
                        assignedTo varchar(20),
                        groupAssigned varchar(20),
                        description varchar(500),
                        solution varchar(500),
                        openTime varchar(100),
                        closeTime varchar(100),
                        INDEX(asset(20)),
                        INDEX(customerSurname(30)),
                        INDEX(category(30))) DEFAULT CHARSET=utf8 ENGINE InnoDB";
    if($execQuery=$connection->query($createSitesTable)) seedTableList('tickets','services');
    else echoResponse('no',$connection->error);
    echoResponse('yes','Enjoy!');
    
}

//function: looking for new messages
if(isset($_POST['checkMessages']))
{
    session_start();
    include_once '../configuration/db.php';
    include_once '../function/funcs.php';
    $connection=new mysqli(HOST,USER,PSW,DB);
    $query="SELECT * FROM messages WHERE target='".$_SESSION['username']."'";
    if(!$exec=$connection->query($query)) echo $connection->error;
    else
    {
        $msg=$exec->num_rows;
        $connection->close();
        echo $msg;
    }
}

//function: looking for new assigned tickets
if(isset($_POST['checkPQueue']))
{
    session_start();
    include_once '../configuration/db.php';
    include_once '../function/funcs.php';
    include_once '../configuration/ClassTicket.php';
    include_once '../configuration/ClassUser.php';
    $connection=new mysqli(HOST,USER,PSW,DB);
    $query="SELECT * FROM tickets WHERE assignedTo='".$_SESSION['surname'].",".$_SESSION['name']."' AND status<>'close'";
    if(!$exec=$connection->query($query)) echo $connection->error;
    else
    {
        $msg=$exec->num_rows;
        $connection->close();
        echo $msg;
    }
}

//function: list assigned tickets
if(isset($_POST['listPersonalQueue']))
{
    session_start();
    include_once 'db.php';
    include_once 'ClassTicket.php';
    
    $name=$_SESSION['name'];
    $surname=$_SESSION['surname'];
    $assignedTo=$surname.",".$name;
    $ticket=new Ticket();
    if($ticket->getTicketBy($assignedTo)) $ticket->printTabledTicketList('open');
    else echo "No Tickets in personal queue";
}

//function: search tkt 
if(isset($_POST['searchTKTbyTOKEN']))
{
    include_once '../configuration/db.php';
    include_once '../configuration/ClassTicket.php';
    $token=$_POST['token'];
    $ticket=new Ticket();
    if($ticket->getTicketBy($token)) $ticket->printTabledTicketList('all');
    else echo 0;
}

//function: search customer
if(isset($_POST['searchCUSTOMERbyTOKEN']))
{
    include_once '../configuration/db.php';
    include_once '../configuration/ClassCustomer.php';
    $token=$_POST['token'];
    $customer=new Customer();
    if($customer->getCustomerBy($token)) $customer->printTabledCustomerList('active');
    else echo 0;
}

//function: search asset
if(isset($_POST['searchASSETbyTOKEN']))
{
    include_once '../configuration/db.php';
    include_once '../configuration/ClassAsset.php';
    $token=$_POST['token'];
    $asset=new Asset();
    if($asset->getAssetBy($token)) $asset->printTabledAssetList('active');
    else echo 0;
}
//function: update tkt

if(isset($_POST['updateTKT']))
{
    include_once '../configuration/db.php';
    include_once '../function/funcs.php';
    include_once '../configuration/ClassTicket.php';

    $id=$_POST['id'];
    $asset=sanitizeInput($_POST['asset']);
    $category=sanitizeInput($_POST['category']);
    $status=sanitizeInput($_POST['status']);
    $assignedTo=sanitizeInput($_POST['assignedTo']);
    $groupAssigned=sanitizeInput($_POST['group']);
    $closeTime=sanitizeInput($_POST['closeTime']);
    $description=sanitizeInput($_POST['description']);
    $solution=sanitizeInput($_POST['solution']);
    $ticket=new Ticket;
    $msg=$ticket->updateTicket($id,$asset,$status,$category,$assignedTo,$groupAssigned,$description,$solution,$closeTime);
    echo $msg;
    
}

//function : update customer

if(isset($_POST['updateCUST']))
{
    include_once '../configuration/db.php';
    include_once '../function/funcs.php';
    include_once '../configuration/ClassCustomer.php';

    $id=$_POST['customerID'];
    $customerName=sanitizeInput($_POST['customerName']);
    $customerSurname=sanitizeInput($_POST['customerSurname']);
    $customerType=sanitizeInput($_POST['customerType']);
    $customerSite=sanitizeInput($_POST['customerSite']);
    $customerStatus=sanitizeInput($_POST['customerStatus']);
    
    $customer=new Customer;
 
    $msg=$customer->updateCustomer($id,$customerSurname,$customerName,$customerType,$customerSite,$customerStatus);
    echo $msg;
    
}

//function: update asset

if(isset($_POST['updateASSET']))
{
    include_once '../configuration/db.php';
    include_once '../function/funcs.php';
    include_once '../configuration/ClassAsset.php';
    
    $originalCode=sanitizeInput($_POST['originalAssetCode']);
    $code=sanitizeInput($_POST['assetCode']);
    $type=sanitizeInput($_POST['assetType']);
    $model=sanitizeInput($_POST['assetModel']);
    $brand=sanitizeInput($_POST['assetBrand']);
    $site=sanitizeInput($_POST['assetSite']);
    $ip=sanitizeInput($_POST['assetIp']);
    $status=sanitizeInput($_POST['assetStatus']);
    $assignee=sanitizeInput($_POST['assetAssignee']);
    
    $asset=new Asset;
 
    $msg=$asset->updateAsset($originalCode,$code,$type,$brand,$model,$site,$ip,$status,$assignee);
    echo $msg;
    
}


//function: create customer

if(isset($_POST['createCUSTOMER']))
{
    include_once '../configuration/db.php';
    include_once '../function/funcs.php';
    include_once '../configuration/ClassCustomer.php';
    
    $customerSurname=sanitizeInput($_POST['customerSurname']);
    $customerName=sanitizeInput($_POST['customerName']);
    $customerType=sanitizeInput($_POST['customerType']);
    $customerSite=sanitizeInput($_POST['customerSite']);
    $customerStatus=sanitizeInput($_POST['customerStatus']);
    
    
    $customer=new Customer;
    $msg=$customer->createCustomer($customerSurname,$customerName,$customerType,$customerSite,$customerStatus);
    if(is_numeric($msg)) echoResponse('yes',$msg);
    else echoResponse('no',$msg);

}

//function: create tkt

if(isset($_POST['createTKT']))
{
    include_once '../configuration/db.php';
    include_once '../function/funcs.php';
    include_once '../configuration/ClassTicket.php';

    $asset=sanitizeInput($_POST['asset']);
    $category=sanitizeInput($_POST['category']);
    $status=sanitizeInput($_POST['status']);
    $customerName=sanitizeInput($_POST['customerName']);
    $customerSurname=sanitizeInput($_POST['customerSurname']);
    $openedBy=sanitizeInput($_POST['openedBy']);
    $assignedTo=sanitizeInput($_POST['assignedTo']);
    $groupAssigned=sanitizeInput($_POST['group']);
    $openTime=sanitizeInput($_POST['openTime']);
    $description=sanitizeInput($_POST['description']);
    
    $ticket=new Ticket;
    $msg=$ticket->createTicket($asset,$status,$category,$customerName,$customerSurname,$openedBy,$assignedTo,$groupAssigned,$description,$openTime);
    if(is_numeric($msg)) echoResponse('yes',$msg);
    else echoResponse('no',$msg);
}

//function: create asset

if(isset($_POST['createASSET']))
{
    include_once '../configuration/db.php';
    include_once '../function/funcs.php';
    include_once '../configuration/ClassAsset.php';
    $code=sanitizeInput($_POST['assetCode']);
    $type=sanitizeInput($_POST['assetType']);
    $brand=sanitizeInput($_POST['assetBrand']);
    $model=sanitizeInput($_POST['assetModel']);
    $site=sanitizeInput($_POST['assetSite']);
    $ip=sanitizeInput($_POST['assetIp']);
    $assignee=sanitizeInput($_POST['assetAssignee']);
 
    
    $asset=new Asset;
    $msg=$asset->createAsset($code,$type,$brand,$model,$site,$ip,$assignee);
    echoResponse('yes',$msg);
    
}



?>