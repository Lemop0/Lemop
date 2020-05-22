<?php
session_start();

$username = $_POST['Username'];
$password = $_POST['Password'];
//1.看有没有这个用户
//2.看密码对不对
$sql = 'select * from `account` where `Username` =\''.str_replace("''",'',$username).'\'';
$sqli = new mysqli('localhost','root','','myblog');
$rs = $sqli->query($sql);
$row = $rs->fetch_assoc();
if ($sqli->connect_error) 
    die("连接失败: " . $sqli->connect_error);


if(!$row) echo "用户名或密码错误！<br/>";
else{
    $passwordIndb = $row["Password"];
    if($passwordIndb!=$password){
        echo "用户名或密码错误<br/>";
    }else{
        //密码验证成功
        //$_SESSION["islogin"] = true;
        //setcookie("user",$row["Id"]);
        //让服务器记住，当前这个访问者已经验证过用户名和密码 
        $_SESSION["user"] = $row;
        header("Location: article_list.php");
    }
}

/*
页面-用户名/密码
do_ login.php
校验用户名密码

让服务器记住这个操作者已经校验过用户名密码
下次访问需要资源保护的页面，就不需要再输入用户名密码。


写文章

需求 - 分析 - 编码 - 测试 - 部署

-数据库有一张表 article: id, 标题title, 内容content, 作者Author, createtime

1 写页面 article_add.php, article_add_do.php

2 文章列表 article_list.php
//标题，作者  搜素，分页，

3 文章详情 article_detail.php

工作项列表


*/


?>