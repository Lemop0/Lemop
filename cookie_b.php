<?php
session_start();
$myname=$_SESSION["myname"];
//$sessId=$_COOKIE["PHPSESSID"]；
//$content = openfile('.../$sessId');
//
echo "my name in session= $myName";