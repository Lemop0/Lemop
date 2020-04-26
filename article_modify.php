<?php
session_start();
$currentUser = $_SESSION["user"];
if(!$currentUser) header("Location: login.html");

function getParam($name){
    $value = isset($_GET[$name])?$_GET[$name]:null;
    $value = str_replace("'","''",$value);
    return $value;
}
$requestMethod = $_SERVER["REQUEST_METHOD"];
if($requestMethod=="GET"){
    //GET方法   link

    $id = getParam("Id");
    $sql = "SELECT * from `article` where Id=$id";
    $conn = new mysqli("localhost","root","root","php");
    $rs = $conn -> query($sql);
    if ($conn->error) die($conn->error);
    $detail = $rs->fetch_assoc();
    if($currentUser["id"]!==$detail["AuthorId"]){
        die("不是作者，不可以修改！");
    }

}else{
    //POST
    $user = $_SESSION["user"];

    $title = $_POST["Title"];
    $content = $_POST["Content"];
    $updateTime = date_format(new DateTime(),'Y-m-d H:i:s');
    $id = getParam("id");

    $sql = "UPDATE `article` SET `Title`='$title',`Content`='$content',`UpdateTime`='$updateTime' WHERE Id=$id AND AuthorId=".$user["id"];
    $conn = new mysqli("localhost","root","root","php");
    $rs = $conn -> query($sql);
    if ($conn->error) die($conn->error);

    $url = "article_list.php";
    Header("Location: $url"); die("");
}


?>

<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <title>修改</title>
    </head>
    <body>
        <form method="POST" action="article_modify.php?id=<?=$id?>">
        <div>
            <label>标题</label>
            <input type="text" name="Title" value="<?=$detail["Title"]?>" />
        </div>
        <div>
            <label>内容</label>
            <textarea name="Content" ><?=$detail["Content"]?></textarea>
        </div>
        <div><?=$detail["AuthorName"]?>编辑于<?=$detail["UpdateTime"]?></div>
        <input type="submit" name="submit" value="提交"/>
        <a href="article_list.php">返回列表</a>
        </form>
    </body>
</html>