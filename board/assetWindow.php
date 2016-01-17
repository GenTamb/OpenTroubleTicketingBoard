<?php
session_start();
include_once '../configuration/db.php';
include_once '../configuration/ClassUser.php';
include_once '../configuration/ClassAsset.php';

include_once '../function/funcs.php';
   
   
//setup user
$user=new User();
setupUser($user);

//setup tkt
$Asset=new Asset();

//get input id
if(isset($_GET['id']))
{
   $token=$_GET['id'];
   $Asset->getAssetBy($token);
}
   
       echo "
       <html>
       <head>";
       if(isset($_GET['new'])) echo "<title>OpenTroubleTicketing | New Asset </title>";
       else echo "<title>OpenTroubleTicketing | View Asset : ".$Asset->code[0]." </title>";
       echo "
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
       
       echo "
           <div class='row'>
               <div class='col-sm-3 col-md-3 col-lg-3>
                   <label for='customerID'>ID</label><br>";
                   if(isset($_GET['new'])) echo "<input type='text' class='disabled editable' id='assetCODE' value=''>";
                   else echo "<input type='text' class='disabled editable' id='assetCODE' value='".$Asset->code[0]."'>"; echo "    
               </div>
               <div class='col-sm-3 col-md-3 col-lg-3>
                  <label for='assetType'>TYPE</label>
                  <input type='text' class='disabled editable' id='assetType' value='".$Asset->type[0]."'>
               </div>
                <div class='col-sm-3 col-md-3 col-lg-3>
                  <label for='assetModel'>MODEL</label>
                  <input type='text' class='disabled editable' id='assetModel' value='".$Asset->model[0]."'>
               </div>
               <div class='col-sm-3 col-md-3 col-lg-3>
                  <label for='assetBrand'>BRAND</label>
                  <input type='text' class='disabled editable' id='assetBrand' value='".$Asset->brand[0]."'>
               </div>
           </div>
           <div class='row'>
               <div class='col-sm-3 col-md-3 col-lg-3>
                  <label for='assetSite'>SITE</label>
                  <input type='text' class='disabled editable' id='assetSite' value='".$Asset->site[0]."'>
               </div>
               <div class='col-sm-3 col-md-3 col-lg-3>
                  <label for='assetIp'>IP</label>
                  <input type='text' class='disabled editable' id='assetIp' value='".$Asset->ip[0]."'>
               </div>
               <div class='col-sm-3 col-md-3 col-lg-3>
                  <label for='customerStatus'>STATUS</label><br>";
                  if(isset($_GET['new'])) echo "<select id='assetStatus'><option value='active' selected>active</option></select>";
                  else
                  switch($Asset->status[0])
                  {
                     case 'active': echo "<select id='assetStatus' class='disabled editable'><option value='active' selected>active</option><option value='de-active'>de-active</option></select>";
                                    break;
                     case 'de-active': echo "<select id='assetStatus'><option value='active'>active</option><option value='de-active' selected>de-active</option></select>";
                                    break;
                  }echo "
               </div>
           </div>
           <div class='container-fluid'>
               ";
               if(isset($_GET['new'])) echo "<button id='createASSET' class='btn btn-info btn-sm'>Create</button>";
               else echo "<button id='editASSET' class='btn btn-danger btn-sm'>Edit</button>";
               echo "<button id='closeASSET' class='btn btn-info btn-sm'>Close Window</button>
           </div>
       </div>
       </body>
       </html>";


?>