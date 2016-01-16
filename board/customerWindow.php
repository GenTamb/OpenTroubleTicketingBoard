<?php
session_start();
include_once '../configuration/db.php';
include_once '../configuration/ClassUser.php';
include_once '../configuration/ClassCustomer.php';

include_once '../function/funcs.php';
   
   
//setup user
$user=new User();
setupUser($user);

//setup tkt
$customer=new Customer();

//get input id
if(isset($_GET['id']))
{
   $token=$_GET['id'];
   $customer->getCustomerBy($token);
}
   
       echo "
       <html>
       <head>";
       if(isset($_GET['new'])) echo "<title>OpenTroubleTicketing | New Customer </title>";
       else echo "<title>OpenTroubleTicketing | View Customer : ".$customer->id[0]." </title>";
       echo "
       <meta charset='utf-8'>
       <meta name='viewport' content='width=device-width, initial-scale=1'>
       <link rel='icon' href='icon/icon.png'/>
       <link rel='stylesheet' href='../style/bootstrap.min.css'>
       <link rel='stylesheet' href='customerWindowStyle.css'>
       <link rel='stylesheet' href='../style/defaultStyle.css'>
       <script src='../js/jquery.min.js'></script>
       <script src='../js/bootstrap.min.js'></script>
       <script src='customerWindowScript.js'></script>
       <script src='../js/defaultScript.js'></script>
       </head>
       <body>
       <div class='container-fluid'>";
       
       echo "
           <div class='row'>
               <div class='col-sm-3 col-md-3 col-lg-3>
                   <label for='customerID'>ID</label><br>";
                   if(isset($_GET['new'])) echo "<span id='customerID'>new</span>";
                   else echo "<span id='customerID'>".$customer->id[0]."</span>"; echo "    
               </div>
               <div class='col-sm-3 col-md-3 col-lg-3>
                  <label for='customerSurname'>SURNAME</label>
                  <input type='text' class='disabled editable' id='customerSurname' value='".$customer->surname[0]."'>
               </div>
                <div class='col-sm-3 col-md-3 col-lg-3>
                  <label for='customerName'>NAME</label>
                  <input type='text' class='disabled editable' id='customerName' value='".$customer->name[0]."'>
               </div>
               <div class='col-sm-3 col-md-3 col-lg-3>
                  <label for='customerType'>TYPE</label>
                  <input type='text' class='disabled editable' id='customerType' value='".$customer->type[0]."'>
               </div>
           </div>
           <div class='row'>
               <div class='col-sm-3 col-md-3 col-lg-3>
                  <label for='customerSite'>SITE</label>
                  <input type='text' class='disabled editable' id='customerSite' value='".$customer->site[0]."'>
               </div>
               <div class='col-sm-3 col-md-3 col-lg-3>
                  <label for='customerStatus'>STATUS</label><br>";
                  if(isset($_GET['new'])) echo "<select id='customerStatus'><option value='active' selected>active</option></select>";
                  else
                  switch($customer->status[0])
                  {
                     case 'active': echo "<select id='customerStatus' class='disabled editable'><option value='active' selected>active</option><option value='de-active'>de-active</option></select>";
                                    break;
                     case 'de-active': echo "<select id='customerStatus'><option value='active'>active</option><option value='de-active' selected>de-active</option></select>";
                                    break;
                  }echo "
               </div>
           </div>
           <div class='container-fluid'>
               ";
               if(isset($_GET['new'])) echo "<button id='createCUST' class='btn btn-info btn-sm'>Create</button>";
               else echo "<button id='editCUST' class='btn btn-danger btn-sm'>Edit</button>";
               echo "<button id='closeCUST' class='btn btn-info btn-sm'>Close Window</button>
           </div>
       </div>
       </body>
       </html>";


?>