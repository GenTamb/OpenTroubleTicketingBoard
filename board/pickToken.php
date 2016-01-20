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
       <head>";
       if(isset($_GET['choose']) && $_GET['choose']=='assignee') echo "<title>OpenTroubleTicketing | Pick Assignee </title>
       <meta charset='utf-8'>
       <meta name='viewport' content='width=device-width, initial-scale=1'>
       <link rel='icon' href='icon/icon.png'/>
       <link rel='stylesheet' href='../style/bootstrap.min.css'>
       <link rel='stylesheet' href='assetWindowStyle.css'>
       <link rel='stylesheet' href='../style/defaultStyle.css'>
       <script src='../js/jquery.min.js'></script>
       <script src='../js/bootstrap.min.js'></script>
       <script src='assetWindowScript.js'></script>
       <script src='../js/defaultScript.js'></script>
       </head>
       <body>
       <div class='container-fluid'>";
   if(isset($_GET['choose']) && $_GET['choose']=='assignee')
   {
       echo "<label for='assignee'>SEARCH ASSIGNEE</label><br>
             <input type='text' id='assignee' value='' placeholder='Search by Surname'>
             <div class='cointainer' id='hintSurname'></div>";
   }
   
   
   
   echo "</div>
         </body>
         </html>";
}
?>