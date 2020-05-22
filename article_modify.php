<?php
require_once("common.inc.php");
if(!$user) header("Location: login.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];
if($requestMethod=="GET"){
    //GET方法   link

    $id = getParam("Id");
    $sql = "SELECT * from `article` where Id=$id";
    $conn = new mysqli("localhost","root","","myblog");
    $rs = $conn -> query($sql);
    if ($conn->error) die($conn->error);
    $detail = $rs->fetch_assoc();
    if($user["id"]!==$detail["AuthorId"]){
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
    $conn = new mysqli("localhost","root","","myblog");
    $rs = $conn -> query($sql);
    if ($conn->error) die($conn->error);
    Header("Location: article_list.php"); die("");
}

require_once("header.inc.php");
?>
    <div class="dataset">
        <form method="POST" action="article_modify.php?id=<?=$id?>">
            <div class="field">
                <label>标题</label>
                <input type="text" name="Title" value="<?=$detail["Title"]?>" />
            </div>
            <div class="field">
                <label>内容</label>
                <textarea name="Content" ><?=$detail["Content"]?></textarea>
            </div>
            <div class="info">
                <?=$detail["AuthorName"]?>编辑于<?=$detail["UpdateTime"]?>
            </div>
            <div class="actions">
                <a href="article_list.php">返回列表</a>
                <input type="submit" name="submit" value="提交"/>
            </div>
        </form>
    </div>
<?php require_once("footer.inc.php"); ?>