<?php
//session
session_start();
$user = isset($_SESSION["user"])?$_SESSION["user"]:null;
if($user) echo "Welcome";
else echo "access denied";

//cookie
/*$myId = isset($_COOKIE["myId"])?$_COOKIE["myId"]:null;
if($myId) echo "Welcome";
else echo "access denied";
*/

?>