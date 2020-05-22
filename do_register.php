<?php

//没有错误
$hasError = false;
//var_dump($_POST);//输出了注册时填写的内容


// 函数 y=f(x); f(x)=x*x+3*x-4
// function f($x,$z){
//     return $x*$x+3*$x-4+$z;
// }
// $y = f(34,23);

function mycount($arr){
    $count = 0;
    foreach($arr as $k=>$v)$count++;
    return $count;
}

function myimplode($arr,$needle){
    $count = mycount($arr);
    $result = ",";
    while($count>0){
        $result = ",".$arr[$count-1].$result;
        $count--;
    }
    return $result;
}

//变量
$username = $_POST["Username"];
//如果有用户名，检查长度
if($username){
    $len = strlen($username);
    if($len<3){
        $hasError = true;
        echo "用户名长度至少为3";
    }else if($len>6){
        $hasError = true;
        echo "用户名长度不能超过6<br/>";
    }
}else{
    echo "用户名必须填写";//如果没有填写用户名，则提醒
    $hasError = true;
}


$password = $_POST["Password"];
//如果有密码，检查长度
if($password){
    $len = strlen($password);
    if($len<6){
        $hasError = true;
        echo "密码长度至少为6";
    }else if($len>20){
        $hasError = true;
        echo "密码长度不能超过20br/>";
    }
}else{
    echo "密码必须填写";//如果没有填写，则提醒
    $hasError = true;
}

//age是只填写了数字的字符串
$age = $_POST["age"];

if($age){
    $ageNum = intval($age);
    if(!$ageNum){
        echo "必须为数字<br/>";
        $hasError = true;
    }
}

$interest = $_POST['interest'];
$interestValue = null;
if(!$interest){
    echo "兴趣必须填写<br/>";
}else{
    $count = mycount($interest);

    if($count<2){
        echo "兴趣必须写2个";
        $hasError = true;
    }else if($count>4){
        echo "兴趣最多填写4个";
        $hasError = true;
    }else{
        $interestValue = myimplode($interest,",");
    }
}
echo "爱好是：".$interestValue."<br/>";

$intro = $_POST["introduce"];


if(!$hasError){
    $sql = "insert into `account` (`Username`,`Password`,`Gender`,``interest`,age`,`introduce`) values ('$username','$password',1,'$age','$interestValue','$intro')";
    $conn = new mysqli('localhost','root','','myblog');
    $conn->query($sql);
    if($conn->error) echo"数据库有错误:$conn->error";
    else{
        echo "注册成功，<a href = 'login.php'请点击这里登录</a><br/>";
    }
}

//



















// $username = "123";
// $gender = 1;

// $arr = [1,3,434];
// //取出数组中的元素
// echo $arr[0];

// $arr = ["name"=>"lemon","gender"=>"女"];
// echo $arr["name"];
// $arr["name"]="pi";
// //输出
// //$var_dump($arr);
// var_dump($_POST);