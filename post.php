<?php
    /*echo"post方法传过来的数据<br/>";
    var_dump($_POST);
    echo"get方法传过来的数据<br/>";
    var_dump($_GET);*/

    function array_length($arr){
        $length = 0;
        foreach($arr as $k=>$v){
            echo" ";
            $length++;

        }
        return $length;
    }
    
    function array_implode($arr,$needle =''){
        $length = array_length($arr);
        $str = $needle;
        $i = 0;
        while($i<$length){
            //$str .=$arr[$i];
            $str = $str . $arr[$i].';';
            $i++;
        }
        return $str;
    }

    $count = 0;

    //检查用户名
    //必须填写；至少3个字符；至多5个字符
    //字母开头，字母数字下划线
    $username =trim( $_POST["Username"]);
    if(!$username){
        echo "用户名必须填写<br />";
        $count++;
    }else{
        $len = strlen($username);
        if($len<3){
            echo "用户名至少3个字符<br / >";
            $count++;
        }else if($len>5){
            echo "用户名最多5个字符<br/>";
            $count++;
        }else if(!preg_match('/^[a-zA-Z0-9_]*$/',$username)){
            echo "格式不符合要求<br/>";
            $count++;
        }
    }

    //检查密码
    $pswd = $_POST["Password"];
    if(!$pswd){
        echo "密码必须填写<br />";
        $count++;
    }else{
        $len = strlen($username);
        if($len<3){
            echo "密码至少5个字符<br / >";
            $count++;
        }else if($len>5){
            echo "密码最多8个字符<br/>";
            $count++;
        }
    }

    $gender = $_POST["Gender"];
    if($gender == 'male')   $gender=1;
    else if($gender == 'female')    $gender=0;
    else $gender=-1;

    //年龄
    //可以不填，填写必须是数字
    $age = trim($_POST["Age"]);
    if($age){
        //
        $ageNum = intval($age);
        if(!$ageNum || $ageNum<0 || $ageNum>200){
            echo"请填写正确的年龄<br/>";
            $count++;
        }
    }

    //兴趣
    $ins = $_POST["interest"];

    $length = array_length($ins);

    if($length<2){
        echo"兴趣必须是多选<br/>";
        $count++;
    }
    $interest = array_implode($ins,"");

    //$province = $_POST["Province"];
    $intro = $_POST["introduce"];

     if($count===0){
         $intro = str_replace("'","''",$intro);
        $conn = new mysqli("localhost", "root", "", "myblog");
        if ($conn->connect_error) 
            die("连接失败: " . $conn->connect_error);

        $sql = "insert into `Account` (`Username`,`Password`,`Gender`,`age`,`introduce`) values ('$username','$password',1,'$age','$interestValue','$intro')";
        echo $sql."<br/>";  

        $conn ->query($sql);
        if($sql){
            echo "注册成功！";     
        }else{
           echo "注册失败！";
        }
     }

    echo "<a href='base_complexForm.html'>返回</a><hr/>";

    // foreach($_POST as $index => $value){
    //     echo "<br/>";
    //     echo "$value";
    // }



/*
通信过程：
1.浏览器(显示了一个网页，里面填写了一-些东西，点击提交)
2.浏览器提交的东西封装成了http的数据流,给了Apache
3.apache找到访问的php文件，http数据转给PHP引擎
4.php引擎加载php文件的内容，把http数据放到$_ POST,$_ GET等超全局变量中
5.开始执行代码
*/
