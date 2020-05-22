<?php
session_start();
$_SESSION["user"] = null ;
//redirect
header("location: article_list.php");
?>