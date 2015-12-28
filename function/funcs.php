<?php
function sanitizeInput($string)
{
    $string= strip_tags($string);
    $string= htmlentities($string);
    $string= stripslashes($string);
    $string=mysql_real_escape_string($string);
    return $string;
}

function echoResponse($stat,$resp)
{
    $status[]=$stat;
    $status[]=$resp;
    echo json_encode($status);
    if($stat=='no') die();
}

function salting($password)
{
    $salt="$4lt";
    $pepper="P3ppe£";
    $token=$salt.$password.$pepper;
    $token=hash('ripemd128',"$token");
    return $token;
}

?>