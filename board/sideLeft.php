<?php
include_once '../function/funcs.php';
if(!checkFirstSetup())
{
    echo "
    <ul id='snapShoot'>
    <li id='assignedToUser'>Assigned To You <span id='personalQueueNumber' class='badge'>0</span></a></li>
    <li id='personalQueue'><a href='#personalQueue' data-toggle='tooltip' data-placement='bottom' title='The not closed ones'>List Ticket Opened and Assigned</a></li>
    </ul>";
}
else
{
    echo "Execute first setup in Control Panel";
}

?>
