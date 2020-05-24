<?php
require_once("common.inc.php");
if(!$user) header("Location: login.php");
$id = getParam("Id");
var_dump($_GET);
echo $id."<br/>";
$sql = "DELETE from `Article` where Id=$id";
echo $sql."<br/>";
$conn=createDb();
$rs = $conn->query($sql);

if ($conn->error) die($conn->error);
header("location: article_list.php");
?>