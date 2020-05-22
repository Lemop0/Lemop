<?php
    require_once("common.inc.php");
    
    var_dump($_POST);
    if(isset($_POST["Submit"])){
        
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
            }else if($len>8){
                echo "用户名最多8个字符<br/>";
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
            $len = strlen($pswd);
            if($len<4){
                echo "密码至少4个字符<br / >";
                $count++;
            }else if($len>8){
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
        $ins = $_POST["Interests"];
    
        $length = array_length($ins);
    
        if($length<2){
            echo"兴趣必须是多选<br/>";
            $count++;
        }
        $interests = array_implode($ins,"");
    
        $province = $_POST["Province"];
        $intro = $_POST["Intro"];
    
         if($count===0){
             $intro = str_replace("'","''",$intro);
    
            $createTime = date_format(new DateTime(),'Y-m-d H:i:s');
            $sql=" INSERT INTO `account` VALUES('','$username','$pswd','$age','$gender','$interests','$province','$intro') ";
            $conn=createDb();
            $conn->query($sql);
            if($conn->error) die($conn->error);
            $id=$conn->insert_id;

            if(isset($_FILES["face"])){
                $faceInfo=$_FILES["face"];
                var_dump($faceInfo);
                $dest=__DIR__."/images/$id.jpg";
                move_uploaded_file($faceInfo["tmp_name"],$dest);
            // }else{
            //     $dest="/liushan/images/$id.jpg";
            //     $src="/liushan/images/default-face.jpg";
            //     copy($src,$dest);
            }
        }
    }
   

    require_once("header.inc.php");
?>
    <div class="dataset">
        <form method="POST" action="" enctype="multipart/form-data"> 
            <div class="field">
                <label>名称：</label>
                <input type="text" name="Username" value="amber" placeholder="请输入"/>
            </div>
            <div class="field">
                <label>头像：</label>
                <input type="file" name="face" title="上传头像""/>
            </div>
            <div class="field">
                <label>密码：</label>
                <input type="password" name="Password"  title="至少要4个字符" value=""/>
            </div>
            <div class="field">
                <label>年龄：</label> 
                <input type="text" name="Age" value=""/>
            </div>

            <div class="field sex">
                <label>性别：</label>
                <input type="radio" name="Gender" value="male"/>男
                <input type="radio" name="Gender" value="female"/>女
            </div>

            <div class="field ins">
                <label>兴趣：</label>
                <input type="checkbox" name="Interests[]" value="game"/>游戏
                <input type="checkbox" name="Interests[]" value="basketball"/>篮球
                <input type="checkbox" name="Interests[]" value="boy"/>男
                <input type="checkbox" name="Interests[]" value="girl"/>女
            </div>

            <div class="field">
                <label>省份：</label>
                <select name="Province">
                    <option value="">请选择</option>
                    <option value="CQ">重庆</option>
                    <option value="SC">四川</option>
                </select>
            </div>

            <div class="field">
                <label>自我介绍：</label>
                <textarea name="Intro" cols="80" rows="10">我叫Amber
                    我现在在四川
                </textarea>
            </div>
            <div class="actions">
            <input type="reset" value="重置" />
            <input type="submit" name="Submit" value="提交"/>
            </div>
        </form>
    </div>

<?php
require_once("footer.inc.php");
?>