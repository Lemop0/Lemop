<?php
echo "以下是post的内容<br/>";
var_dump($_POST);

echo "<br/>以下是GET的内容<br/>";
var_dump($_GET);


/*
//如果我的form用GET方法提交，PHP就用$_GET来接数据
//如果我的form用POST方法提交，PHP就用$_POST来接数据


1、浏览器会显示一个网页，可能是服务器写的，也可能是本地给的
2、按提交之后，浏览器会打包数据，发送给服务器
3、Apache收到该数据包，找到要访问的文件
4、转给PHP引擎（php.exe）去处理
5、PHP会把数据注入到$_GET/$_POST
6、加载文件并执行
7、PHP引擎产生的输出，打一个包还给浏览器
8、浏览器根据返回的数据，显示新的页面

*/

?>