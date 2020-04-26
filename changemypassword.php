<?php
//只能登录的用户才能访问
//未登录用户报错
session_start();
//$islogin = isset($_SESSION["islogin"])? $_SESSION["islogin"]:false;
if(isset($_SESSION["islogin"])){
    $islogin = $_SESSION["$islogin"];
}else{
    $islogin =false;
}
if(!$islogin){
    echo "未登录，先登录";
}else{
    echo "修改";
}
?>