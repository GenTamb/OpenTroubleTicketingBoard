<?php
require_once '../../configuration/ClassUser.php';
require_once '../../configuration/db.php';
require_once '../../function/funcs.php';
session_start();
checkLogin();
if(isset($_POST['set']))
{
    if(checkFirstSetup()) echo "si";
}

?>