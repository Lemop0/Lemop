<?php 
require_once("common.inc.php");
require_once("header.inc.php");
?>  

<div class="loginBox">
        <form action="do_login.php" method="POST">
            <h1>用户登录</h1>
            <div class="field">
                名称：<input type="text" name="Username" value="" placeholder="请输入"/>
            </div>
            <div class="field">
                密码：<input type="password" name="Password"  title="至少要4个字符" value=""/>
            </div>

            <input type="reset" value="重置" />
            <input type="submit" name="Submit" value="提交"/>
        </form>
    </div>      
<?php require_once("footer.inc.php");?>