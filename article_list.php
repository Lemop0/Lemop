<?php
session_start();
$user = isset($_SESSION["user"])?$_SESSION["user"]:null;
$userId = $user?$user["id"]:null;

function getParam($name){
    $value = isset($_GET[$name])?$_GET[$name]:null;
    $value = str_replace("'","''",$value);
    return $value;
}

$pageSize = 3;
$pageIndex = isset($_GET["pageIndex"])?trim($_GET["pageIndex"]):1;
$starRow = ($pageIndex-1) * $pageSize;

$sql="select * from `article`" ;
$where = "";

$queryTitle = getParam("Title");
if($queryTitle){
    $where .= " Title like('%$queryTitle%') ";
}

$queryAuthor = getParam("Author");
if($queryAuthor){
    if($where)
        $where .= "AND";
    $where .= " AuthorName like('%$queryAuthor%') ";
}

$queryMinDate = getParam("minDate");
if($queryMinDate){
    if($where)
        $where .= "AND";
    $where .= " CreateTime >= '$queryMinDate' ";
}
$queryMaxDate = getParam("maxDate");
if($queryMaxDate){
    if($where)
        $where .= "AND";
    $where .= " CreateTime <= '$queryMaxDate' ";
}

if($where) 
    $sql .= " WHERE $where ";

$conn = new mysqli("localhost","root","root","php");
$rows = [];
$sql .= " LIMIT $starRow,$pageSize ";
$rs = $conn->query($sql);
while($row = $rs->fetch_assoc()){
    $rows[]=$row;
}
$rs->close();

$total = 0;
$sql = " SELECT count(Id) as t FROM `article` ";
if($where) 
    $sql .= " WHERE $where ";
$rs = $conn->query($sql);
$total = $rs->fetch_assoc()["t"];

$pageCount = ceil($total/$pageSize);
if($pageCount<$pageIndex) $pageIndex = $pageCount;
if($pageIndex<1) $pageIndex = 1;

function pageURL($pageIndex){
    $pageString = "pageIndex=$pageIndex";
    foreach ($_GET as $k => $v) {
        if($k==="pageIndex") continue;
        $pageString .="&$k=$v";
    }
    return $pageString;
}
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
        <title>文章列表</title>
        <link type="text/css" rel="stylesheet" href="themes/default.css">
        <style>
            *{
                font-size:14px; 
                padding: 0;
                margin: 0;
            }
            a{
                list-style: none; 
                text-decoration: none;
            }
            table{ 
                width: 100%; 
                align-content: center; 
                background: #fee;
                border-collapse:collapse;
                border:1px solid #000;
            }
            table td,table th{
                padding: 5px;
                text-align: center;
                border-collapse: collapse;
                border:1px solid #ccc;
            }
            table th{ 
                background:cadetblue;
            }
            .filter{
                margin:10px 0px;
            }

        </style>
    </head>
    <body>
    <div id="layout">
            <div id="header">
                <div class="container">
                    <h1 class="col-10">我的博客系统</h1>
                    <div id="user-info" class="col-2"> 
                        <span id="user-name">
                        <?php if($user){ ?>
                                <?=$user["username"]?>
                                <a href="logout.php">退出</a>
                            <?php } else{ ?>                
                                <a href="login.html">请先登陆</a>       
                        <?php } ?>
                        </span>
                    </div>
                </div>
                <div id="main-menu">
                    <ul class="topMenu">
                        <li>首页</li>
                        <li>文章</li>
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
                <div id="workspace"></div>
                <div id="extras"></div>
            </div>
            <div id="footer">
                <div id="quick-access"></div>
                <div id="copyright">
                    <p>Amber@qq.com All right reserved.</p>
                </div>
            </div>
        </div>




        <?php if($user){ ?>
        <div> 
            <?=$user["username"]?>
            <a href="logout.php">退出</a>
        <?php } else{ ?>                
            <a href="login.html">请先登陆</a>    
        </div>
        <?php } ?>
        <h3>文章列表</h3>
        <a href="article_add.php"" >新建文章</a>
        <form action="" class="filter" method="GET">
            <span>
                <label>标题</label>
                <input type="text" name="Title" id="Title" value="<?=$queryTitle?>"/>
            </span>
            <span>
                <label>作者</label>
                <input type="text" name="Author" id="Author" value="<?=$queryAuthor?>"/>
            </span>
            <span>
                <label>时间</label>
                <input type="text" name="minDate" value="<?=$queryMinDate?>"> - <input type="text" name="maxDate" value="<?=$queryMaxDate?>">
            </span>
            <input type="submit" name="Submit" value="搜索" />
        </form>

    <script type="text/javascript">
    function jumpTo(pageIndex){
        var url ="?";
        var form = document.getElementById("form");
        var data = getData(form,{});
        for (var n in data){
            url += "&" + n +"=" + data[n];
        }
        url += "&pageIndex=" + pageIndex;
        location.href = url;
    }
    function getData(form,data){
        for( let i=0 ,j=form.childNodes.length; i<j;i++){
            let child = form.childNodes[i];
            if(child.tagName == "INPUT")    data[child.name] = child.value;
            if(child.childNodes && child.childNodes.length) getData(child,data);
        }
        return data;
    }
    </script>
        <table border="1">
            <thead>
                <tr>
                    <th>标题</th>
                    <th>作者</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($rows as $row){?>
                <tr>
                    <td>
                    <a href="article_detail.php?Id=<?=$row["Id"]?>"><?=$row["Title"]?></a>
                    </td>
                    <td>
                        <?=$row["AuthorName"]?>
                    </td>
                    <td>
                        <?=$row["CreateTime"]?><br/>
                        <?=$row["UpdateTime"]?>
                    </td>
                    <td>
                        <a href="article_detail.php?Id=<?=$row["Id"]?>">详情</a>
                        <?php if($userId===$row["AuthorId"]) { ?>
                            <a href="article_modify.php?Id=<?=$row["Id"]?>">修改</a>
                            删除 
                        <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">
                        共<?=$total?>条记录，<?=$pageCount?>页，当前第<input type="text" value="<?=$pageIndex?>" onblur="jumpTo(this.value)"/>页，
                        <a href="article_list.php?<?=pageURL(1)?>">首页</a>< 
                            <?php for($i=1 ; $i<=$pageCount ; $i++){?>
                                <a href="article_list.php?<?=pageURL($i)?>"> <?=$i?> </a>                            
                            <?php } ?>
                        > 
                        <a href="article_list.php?<?=pageURL($pageCount)?>">尾页</a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>

</html>