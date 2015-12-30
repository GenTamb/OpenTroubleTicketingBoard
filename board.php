<?php
session_start();
foreach($_SESSION as $key) echo $key;
?>