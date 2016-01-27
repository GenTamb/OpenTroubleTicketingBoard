<?php
session_start();
include_once '../configuration/db.php';
include_once '../configuration/ClassUser.php';
include_once '../configuration/ClassAsset.php';
include_once '../configuration/ClassCustomer.php';
include_once '../function/funcs.php';

if(checkLogin()){
    echo "
       <html>
       <head>
       <title>OpenTroubleTicketing | ";
       if(isset($_GET['choose']) && $_GET['choose']=='assignee') echo "Pick Customer </title>";
       if(isset($_GET['choose']) && $_GET['choose']=='asset') echo "Pick Asset </title>";
       if(isset($_GET['choose']) && $_GET['choose']=='category') echo "Pick Category </title>";
       echo"
       <meta charset='utf-8'>
       <meta name='viewport' content='width=device-width, initial-scale=1'>
       <link rel='icon' href='icon/icon.png'/>
       <link rel='stylesheet' href='../style/bootstrap.min.css'>
       <link rel='stylesheet' href='../style/defaultStyle.css'>
       <link rel='stylesheet' href='pickToken.css'>
       <script src='../js/jquery.min.js'></script>
       <script src='../js/bootstrap.min.js'></script>
       <script src='../js/defaultScript.js'></script>
       <script src='pickToken.js'></script>";
       echo "
       </head>
       <body>
       <div class='container-fluid'>";
   if(isset($_GET['choose']) && $_GET['choose']=='assignee')
   {
       echo "<label for='assignee'>SEARCH ASSIGNEE</label><br>
             <input type='text' id='assignee' value='' placeholder='Search by Surname'>";
             
   }
   if(isset($_GET['choose']) && $_GET['choose']=='asset')
   {
       echo "<label for='asset'>SEARCH ASSET</label><br>
             <input type='text' id='asset' value='' placeholder='Search by Code'>";
   }
   if(isset($_GET['choose']) && $_GET['choose']=='asset')
   {
    
   }
   
   
   echo "<div class='cointainer' id='hintsGot'></div>";
   echo "</div>
         </body>
         </html>";
}
?>