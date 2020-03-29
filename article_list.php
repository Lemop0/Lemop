<?php
$pageSize = 3;
$pageIndex = isset($_GET["pageIndex"])?$_GET["pageIndex"]:1;
$starRow = ($pageIndex-1) * $pageSize;

$sql="select * from `article`" ;
$where = "";
$hasWhere = false;

$queryTitle = isset($_GET["Title"])?$_GET["Title"]:null;
if($queryTitle){
    $where .= " Title like('%$queryTitle%') ";
}

$queryAuthor = isset($_GET["Author"])?$_GET["Author"]:null;
if($queryAuthor){
    if($where)
        $where .= "AND";
    $where .= " AuthorName like('%$queryAuthor%') ";
}

$queryMinDate = isset($_GET["minDate"])?$_GET["minDate"]:null;
if($queryMinDate){
    if($where)
        $where .= "AND";
    $where .= " CreateTime >= '$queryMinDate' ";
}
$queryMaxDate = isset($_GET["maxDate"])?$_GET["maxDate"]:null;
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
    </head>
    <body>
        <h3>文章列表</h3>
        <a href="article_add.php"" >新建文章</a>

        <form action="" method="GET">
            <div>
                <label>标题</label>
                <input type="text" name="Title" id="Title" value="<?=$queryTitle?>"/>
            </div>
            <div>
                <label>作者</label>
                <input type="text" name="Author" id="Author" value="<?=$queryAuthor?>"/>
            </div>
            <div>
                <label>时间</label>
                <input type="text" name="minDate" value="<?=$queryMinDate?>"> - <input type="text" name="maxDate" value="<?=$queryMaxDate?>">
            </div>
            <input type="submit" name="Submit" value="搜索" />
        </form>
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
                        <?=$row["Title"]?>
                    </td>
                    <td>
                        <?=$row["AuthorName"]?>
                    </td>
                    <td>
                        <?=$row["CreateTime"]?><br/>
                        <?=$row["UpdateTime"]?>
                    </td>
                    <td>
                        详情 修改 删除 
                    </td>
                </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4">
                        共<?=$total?>条记录，<?=$pageCount?>页，当前第<input type="text" value="<?=$pageIndex?>" />页，
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