
<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <title>文章列表</title>
        <link type="text/css" rel="stylesheet" href="themes/default.css">

    </head>
    <body>
    <div id="layout">
            <div id="header">
                <div class="container">
                    <h1 class="col-9">我的博客系统</h1>
                    <div id="user-info" class="col-3"> 
                        <?php if($user){ ?>
                            <span id="user-name"><?=$user["Username"]?></span>
                            <a href="logout.php">退出</a>
                            <?php } else{ ?>     
                                <span id="user-name">访客</span>           
                                <a href="login.php">请登陆</a><br/>
                                <span id="user-name">没有账号</span>  
                                <a href="register.php">去注册</a>     
                        <?php } ?>
                        
                    </div>
                </div>
                <div id="main-menu">
                    <ul class="topMenu">
                        <li>首页</li>
                        <li><a href="article_list.php">文章</a></li>
                        <li id="manage">
                            <span>管理</span>
                            <ul>
                                <li><span>用户</span></li>
                                <li>
                                    <span>基础数据</span>
                                    <ul>
                                        <li>皮肤管理</li>
                                        <li>兴趣管理</li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="main">
                <div id="workspace">
