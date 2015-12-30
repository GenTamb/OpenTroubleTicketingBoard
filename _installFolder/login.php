<!DOCTYPE html>
<?php
session_start();
require_once "function/funcs.php";
if(checkInstallation())
{
    echo "
    <head>
    <title>OpenTroubleTicketing: ".getBoardName()."</title>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='icon' href='icon/icon.png'/>
    <link rel='stylesheet' href='style/bootstrap.min.css'>
    <link rel='stylesheet' href='login/loginStyle.css'>
    <link rel='stylesheet' href='style/defaultStyle.css'>
    <script src='js/jquery.min.js'></script>
    <script src='js/bootstrap.min.js'></script>
    <script src='login/loginScript.js'></script>
    <script src='js/defaultScript.js'></script>
    </head>
    <body>
    <div class='container-fluid title text-center'>
    <h1>Welcome to ".getBoardName()."</h1>
    <h2>managed by ".getOrgName()."</h2>
    </div>
    <div class='container-fluid defaultWidth text-center loginForm'>
    <h3>Login Form</h3>
    <form role='form' method='post'>
    <div class='form-group'>
    <label for='userName'>Enter your username:</label>
    <input type='text' placeholder='who are you?' id='username'>
    </div>
    <div class='form-group'>
    <label for='password'>Enter your password:</label>
    <input type='password' placeholder='your secret password?' id='password'>
    </div>
    <input type='submit' class='btn btn-warning btn-sm' value='send' id='send'>
    </form>
    </div>
    </body>
    </html>";
}
?>

