<html>
    <head>
        <title>First page</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        
    </head>

    <body>
        <h1>注册</h1>
        <form action="post.php" method="POST">
            <div>
                 用户名:<input type="text" value="lemon" name="Username" placeholder="输入用户名"/>
            </div>
            <div>
                密码:<input type="password" value="lemon" name="Password" placeholder="输入密码" title="至少要有4个字符"/>
            </div>
            <div>
                年龄:<input type="text" value="" name="age" title="必须为数字"/>
            </div>
            <div>
                性别:
                男<input type="radio" value="male" name="Gender"/> 
                女<input type="radio" value="female" name="Gender" checked/> 
            </div>
            <div>
                兴趣爱好:
                足球<input type="checkbox" value="football" name="interest[]"/> 
                游泳<input type="checkbox" value="swimming" name="interest[]"/>
                作业<input type="checkbox" value="homework" name="interest[]"/> 
                代码<input type="checkbox" value="coding" name="interest[]"/>
            </div>
            <div>
                出生月份
                <select name="Birthday_Month">
                    <option value="1">1月</option>
                    <option value="2">2月</option>
                    <option value="3" selected>3月</option>
                    <option value="4">4月</option>
                    <option value="5">5月</option>
                </select>
            </div>
            <div>
                自我介绍:
                <textarea name="introduce" cols="80" rows="10"></textarea>
            </div>
            <input type="submit" value="提交"/>
         </form>             
    </body>
</html>
