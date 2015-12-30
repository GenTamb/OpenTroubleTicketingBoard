<!DOCTYPE html>
<?php
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
    <div class='container-fluid'>login page</div>
    </body>
    </html>";
}
?>

