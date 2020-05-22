<?php
require_once("common.inc.php");
if(!$user) header("Location: login.php");
$id = getParam("Id");
$sql = "delete from `article` where Id=$id ";

$rs = $conn -> query($sql);
if ($conn->error) die($conn->error);
header("location: article_list.php");
?>