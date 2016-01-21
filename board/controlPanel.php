<?php
            
require_once ('../configuration/db.php');
require_once ('../configuration/ClassUser.php');
require_once ('../function/funcs.php');
session_start();
checkLogin();


if(isset($_POST['set']))
{
    if(checkFirstSetup()) echo "
    <script src='board/scriptCC.js'></script>
    <link rel='stylesheet' href='board/boardStyle.css'>
    <h1>First Setup</h1>
    <div class='container-fluid'>
    <form role='form' id='rcNameForm'>
      <div class='form-group'>
        <h2>Enter info for the very first group, you can add others later.</h2>
        <p>The first group should be where you, the admin, belong</p>
        <label for='remoteGroupName'>RC Name:</label>
        <input type='text' id='remoteGroupName' placeholder='Usually is the remote Helpdesk'>
      </div>
      <input type='submit' id='sendRCgroup' value='send' class='btn btn-warning btn-sm' size='30'>
    </form>
    <form role='form' id='createCustomersTable' class='divHidden'>
      <div class='form-group'>
        <h2>Enter the Customers Table's name</h2>
        <label for='customersTable'>Customers Table's Name:</label>
        <input type='text' id='customersTableName' placeholder='Just type Customer if you don't want to use a custom name'>
      </div>
      <input type='submit' id='sendCTN' value='send' class='btn btn-warning btn-sm' size='30'>
    </form>
     <form role='form' id='finishSetup' class='container divHidden'>
        <div class='form-group'>
        <h2>We have almost finished this setup</h2>
        <p>By clicking the button down here, will be created the last 2 critical tables: ASSETS and SITES<br>You can add assets and sites later (only admins and super users will do that).</p>
        </div>
        <input type='submit' id='completeSetup' class='btn btn-warning btn-sm' value='Finish' size='30'>
     </form>
     </div>
    <div class='container-fluid divHidden' id='complete'>
    <h2>First Setup Complete!<br>Now you must add Customers, Sites, Assets and more groups as you like.<br>Enjoy Open Trouble Ticketing!</h2>
    </div>
    </div>";
    if(!checkFirstSetup()) echo "
    <script src='board/scriptCC.js'></script>
    <link rel='stylesheet' href='board/boardStyle.css'>
    <div class='container' id='menu'>
    <h2>Command Center</h2>
      <div class='cointainer' id='controlList'>
        <ul>
            <li><button class='btn btn-info btn-sm cbutton' id='userPanel'>User Panel</button></li>
            <li><button class='btn btn-info btn-sm cbutton' id='groupPanel'>Group Panel</button></li>
            <li><button class='btn btn-info btn-sm cbutton' id='sitePanel'>Site Panel</button></li>
            <li><button class='btn btn-info btn-sm cbutton' id='categoryPanel'>Category Panel</button></li>
        </ul>
      </div>
    </div>
   
    ";
}

?>

 

    
    

