<?php
date_default_timezone_set("PRC");
session_start();
$user = isset($_SESSION["user"])?$_SESSION["user"]:null;
if(!$user){
    echo "未登录，请先去<a href='login.html'>登陆</a>";
}else{
    $title=$_POST["Title"];
    $content=$_POST["Content"];
    $createTime=(new Datetime())->format('Y-m-d H:i:s');
    $updateTime=$createTime;
    $authorId=$user["Id"];
    $authorName=$user["Username"];

    $sql = "INSERT INTO `Article`(`Title`,`Content`,`Create Time`,`Update Time`,`AuthorId`,`AuthorName`) VALUES ('$title','$content','$createTime','$updateTime','$authorId','$authorName')";
    echo $sql;
    $conn = new mysqli("localhost","root","","myblog");
    $conn->query($sql);
    if($conn->error)  die($conn->error);
    else echo "添加文章成功！" ;
}
?>