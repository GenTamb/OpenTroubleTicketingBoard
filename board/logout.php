<?php
session_start();
require_once '../function/funcs.php';
if(isset($_POST['logout']))
{
    session_destroy();
    echoResponse('yes','Logged Out');
}
?>