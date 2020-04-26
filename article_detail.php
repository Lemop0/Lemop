<?php
$id = $_GET["Id"];
$sql = "SELECT * from `article` where Id=$id";
$conn = new mysqli("localhost","root","root","php");
$rs = $conn -> query($sql);
if ($conn->error) die($conn->error);
$detail = $rs->fetch_assoc();
?>

<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <title>文章详情</title>
    </head>
    <body>
        <h3><?=$detail["Title"]?></h3>
        <div><?=$detail["AuthorName"]?>编辑于<?=$detail["UpdateTime"]?></div>
        <div><?=$detail["Content"]?></div>
        <a href="article_list.php">返回列表</a>
    </body>
</html>