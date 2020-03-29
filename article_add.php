<?php
session_start();
$user = isset($_SESSION["user"])?$_SESSION["user"]:null;
if(!$user){
    echo "未登录，请先去<a href='login.html'>登陆</a>";
}else{
?>

<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <title>文章模块</title>
    </head>
    <!--这是注释-->
    <body>
        <h3>新添文章</h3>
        <form action="article_add_do.php" method="post">
            <div>
                <label>标题</label>
                <input type="text" name="Title" id="Title"/>
            </div>
            <div>
                <label>内容</label>
                <textarea name="Content" id="Content"  cols="80" rows="20"></textarea>
            </div>
            <div>
                <label>作者</label>
                <span>
                    <?=$user["username"]?>
                </span>
            </div>

            <div>
                <input type="submit" value="提交"/>
                <input type="reset" value="重置"/> 
            </div>         
        </form>
    </body>

</html>

<?php } ?>