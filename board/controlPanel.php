<?php
            
require_once ('../configuration/db.php');
require_once ('../configuration/ClassUser.php');
require_once ('../function/funcs.php');
session_start();
checkLogin();


if(isset($_POST['set']))
{
    if(checkFirstSetup()) echo "
    <script src='board/controlPanel/scriptCC.js'></script>
    <link rel='stylesheet' href='board/boardStyle.css'>
    <h1>First Setup</h1>
    <form role='form' id='rcNameForm'>
      <div class='form-group'>
        <h2>Enter info for the very first group, you can add others later.</h2>
        <p>The first group should be where you, the admin, belong</p>
        <label for='remoteGroupName'>RC Name:</label>
        <input type='text' id='remoteGroupName' placeholder='Usually is the remote Helpdesk'>
      </div>
      <input type='submit' id='sendRCgroup' value='send' class='btn btn-warning btn-sm'>
    </form>
  
";
}

?>

    
    

