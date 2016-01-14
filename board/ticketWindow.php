<?php
session_start();
include_once '../configuration/db.php';
include_once '../configuration/ClassUser.php';
include_once '../configuration/ClassTicket.php';
include_once '../configuration/Ticket.php';
include_once '../function/funcs.php';
   
   
//setup user
$user=new User();
setupUser($user);

//setup tkt
$ticket=new Ticket();

//get input id
if(isset($_GET['id']))
{
   $id=$_GET['id'];
   $ticket->getTicketBy($id);
}
   
   //checking group afference
   if($user->getGroup()==$ticket->groupAssigned || $user->getPosition()=='admin')
   {
       echo "
       <html>
       <head>";
       if(isset($_GET['new'])) echo "<title>OpenTroubleTicketing | New Ticket </title>";
       else echo "<title>OpenTroubleTicketing | View Ticket : ".$ticket->id[0]." </title>";
       echo "
       <meta charset='utf-8'>
       <meta name='viewport' content='width=device-width, initial-scale=1'>
       <link rel='icon' href='icon/icon.png'/>
       <link rel='stylesheet' href='../style/bootstrap.min.css'>
       <link rel='stylesheet' href='ticketWindowsStyle.css'>
       <link rel='stylesheet' href='../style/defaultStyle.css'>
       <script src='../js/jquery.min.js'></script>
       <script src='../js/bootstrap.min.js'></script>
       <script src='ticketWindowsScript.js'></script>
       <script src='../js/defaultScript.js'></script>
       </head>
       <body>
       <div class='container-fluid'>";
       if(isset($_GET['new'])) echo "<span id='tktID' hidden='true'>new</span>";
       else echo "<span id='tktID' hidden='true'>".$ticket->id[0]."</span>";
       echo "
           <div class='row'>
               <div class='col-sm-3 col-md-3 col-lg-3 space'>
                   <label for='tktCustomer'>Customer</label><br>";
                   if(isset($_GET['new'])) echo "<input type='text' class='disabled editable' id='tktCustomer' placeholder='surname,name' value=''>";
                   else echo "<input type='text' class='disabled' id='tktCustomer' value='".$ticket->customerSurname[0].",".$ticket->customerName[0]."'>";
               echo " 
               </div>
               <div class='col-sm-3 col-md-3 col-lg-3 space'>
                   <label for='tktAsset'>Asset</label><br>
                   <input type='text' class='disabled editable' id='tktAsset' value='".$ticket->asset[0]."'>
               </div>
               <div class='col-sm-3 col-md-3 col-lg-3 space'>
                   <label for='tktCategory'>Category</label><br>
                   <input type='text' class='disabled editable' id='tktCategory' value='".$ticket->category[0]."'>
               </div>
                <div class='col-sm-3 col-md-3 col-lg-3 space'>
                   <label for='tktStatus'>Status</label><br>
                   <input type='text' class='disabled editable' id='tktStatus' value='".$ticket->status[0]."'>
               </div>
           </div>
           <div class='row'>
               <div class='col-sm-3 col-md-3 col-lg-3 space'>
                   <label for='tktOpenedBy'>Opened By</label><br>";
                   if(isset($_GET['new'])) echo "<input type='text' class='openedBy' id='tktOpenedBy' value='".$user->getSurname().",".$user->getName()."'>";
                   else echo "<input type='text' class='disabled' id='tktOpenedBy' value='".$ticket->openedBy[0]."'>";
                   echo "
               </div>
               <div class='col-sm-3 col-md-3 col-lg-3 space'>
                   <label for='tktAssignedTo'>Assigned To</label><br>
                   <input type='text' class='disabled editable' id='tktAssignedTo' value='".$ticket->assignedTo[0]."'>
               </div>
               <div class='col-sm-3 col-md-3 col-lg-3 space'>
                   <label for='tktGroup'>Group Assigned</label><br>
                   <input type='text' class='disabled editable' id='tktGroup' value='".$ticket->groupAssigned[0]."'>
               </div>
           </div>
           <div class='row'>
               <div class='col-sm-3 col-md-3 col-lg-3 space'>
                   <label for='tktOpenTime'>Open Time</label><br>
                   <input type='text' class='time' id='tktOpenTime' value='".$ticket->openTime[0]."'>
               </div>
               <div class='col-sm-3 col-md-3 col-lg-3 space'>
                   <label for='tktCloseTime'>Close Time</label><br>
                   <input type='text' class='time' id='tktCloseTime' value='".$ticket->closeTime[0]."'>
               </div>
           </div>
           <div class='container-fluid'>
                   <label for='tktDescription'>Description</label><br>
                   <textarea row='5' cols='100' class='disabled editable' id='tktDescription'>".$ticket->description[0]."</textarea>
           </div>
           <div class='container-fluid'>
                   <label for='tktSolution'>Solution</label><br>
                   <textarea row='5' cols='100' class='disabled editable solution' id='tktSolution'>".$ticket->solution[0]."</textarea>
           </div>
           <div class='container-fluid'>
               ";
               if(isset($_GET['new'])) echo "<button id='createTKT' class='btn btn-info btn-sm'>Create</button>";
               else echo "<button id='editTKT' class='btn btn-danger btn-sm'>Edit</button>";
               echo "<button id='closeTKT' class='btn btn-info btn-sm'>Close Window</button>
           </div>
       </div>
       </body>
       </html>";
       }
else
       {
           echo "You cannot view this TKT!";
       }



?>
