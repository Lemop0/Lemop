<?php
session_start();
//1.看有没有这个用户
//2.看密码对不对
$username = $_POST['Username'];
$password = $_POST['Password'];

$sql = "select `Password` from Account where Username ='$username'";
$sqli = new mysqli('localhost','root','','myblog');
if ($sqli->connect_error) 
    die("连接失败: " . $sqli->connect_error);
$rs = $sqli->query($sql);
$row = $rs->fetch_assoc();

if(!$row) echo "用户名或密码错误！<br/>";
else{
    $passwordInDb = $row["Password"];
    if($passwordInDb!=$password){
        echo "用户名或密码错误<br/>";
    }else{
        //密码验证成功
       //让服务器记住，当前这个访问者已经验证过用户名和密码 
       // setcookie("myId",$row["id"]);

        $_SESSION["islogin"] = true;
        echo "登录成功！<br/>";
    }
}

/*
页面-用户名/密码
do_ login.php
校验用户名密码

让服务器记住这个操作者已经校验过用户名密码
下次访问需要资源保护的页面，就不需要再输入用户名密码。

*/
?>