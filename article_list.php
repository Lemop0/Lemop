<?php
require_once("common.inc.php");

//卡片和列表切换
// $theme = isset($_GET["theme"])?$_GET["theme"]:null;
// if(!$theme){
//     $theme = isset($_COOKIE["theme"])?$_COOKIE["theme"]:null;
// }else{
//     setcookie("theme",$theme);
// }


$conn = createDb();
$pageSize = 5;
$pageIndex = isset($_GET["pageIndex"])?trim($_GET["pageIndex"]):1;

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

$pageInfo = pageable("article",$where,$pageIndex,$pageSize);
$rows = $pageInfo["items"];
var_dump($rows);
$pageCount = $pageInfo["pageCount"];
$total = $pageInfo["total"];

require_once("header.inc.php");
?>
        <h3>文章列表</h3>
        <a href="article_add.php"" >新建文章</a>
                <div  class="form">
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
                        <input type="submit" name="Submit" value="搜索" class="submit"/>
                    </form>
                </div>

                <span class="btn" id="listBtn">列表</span>
                <span class="btn" id="cardBtn">卡片</span>
                    <div id="panel" class="list">           
                        <div class="table">
                            <div class="thead">
                                <div class="tr">
                                    <div class="th"><span class="title">标题</span></div>
                                    <div class="th">作者</div>
                                    <div class="th">创建时间</div>
                                    <div class="th">操作</div>
                                </div>
                            </div>
                            <div class="tbody" >
                                <?php foreach($rows as $row){?>
                                <div class="tr">
                                    <div class="td Title">
                                    <a href="article_detail.php?Id=<?=$row["Id"]?>"><?=$row["Title"]?></a>
                                    </div>
                                    <div class="td Author">
                                        <img class="user-face" src="<?="/Lemop/images/".$row["AuthorId"].".jpg"?>" />
                                        <?=$row["AuthorName"]?>
                                    </div>
                                    <div class="td">
                                        <?=$row["CreateTime"]?><br>
                                        <?=$row["UpdateTime"]?>
                                    </div>
                                    <div class="td">
                                        <a href="article_detail.php?Id=<?=$row["Id"]?>">详情</a>
                                        <?php if($userId===$row["AuthorId"]) { ?>
                                            <a href="article_modify.php?Id=<?=$row["Id"]?>">修改</a>
                                            <a href="article_delete.php?Id=<?=$row["Id"]?>" class="delete">删除</a>
                                        <?php } ?>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <script type="text/javascript">
                                listBtn.onclick = function(){
                                    var span = document.getElementById("panel");
                                    span.className = "list";
                                };
                                cardBtn.onclick = function(){
                                    var span = document.getElementById("panel");
                                    span.className = "card";
                                }; 

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
                        </div>
                    </div>
                    <div id="recordInfo"> 
                        共<?=$total?>条记录，<?=$pageCount?>页，当前第<input type="text" value="<?=$pageIndex?>" onblur="jumpTo(this.value)"/>页，
                        <a href="article_list.php?<?=pageURL(1)?>">首页</a>< 
                            <?php for($i=1 ; $i<=$pageCount ; $i++){?>
                                <a href="article_list.php?<?=pageURL($i)?>"> <?=$i?> </a>                            
                            <?php } ?>
                        > 
                        <a href="article_list.php?<?=pageURL($pageCount)?>">尾页</a>
                    </div>
                <script type="text/javascript">
                var deleteLinks = document.getElementsByClassName("delete");
                for(var i=0,j=deleteLinks.length;i<j;i++){
                    var link = deleteLinks[i];
                    link.onclick = function(e){
                        e = e || event;
                        var confirmd = confirm("你确定要删除吗？");
                        if(!confirmd){
                            e.preventDefault();
                            return false;
                        }
                    }
                }
                </script>
<?php require_once("footer.inc.php");?>