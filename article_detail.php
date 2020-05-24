<?php
require_once("common.inc.php");

function writeHtmlContent($content){
    $content = str_replace("<","&lt",$content);
    $content = str_replace(" ","&nbsp",$content);
    $content = str_replace("\n","<br />",$content);
    return $content ;
}
$conn = createDb();

$id = $_GET["Id"];
$sql = "SELECT * from `Article` where Id = $id";
$rs = $conn->query($sql);
if ($conn->error) die($conn->error);
$detail = $rs->fetch_assoc();
$rs->close();

$pageIndex = isset($_GET["pageIndex"])?$_GET["pageIndex"]:1;
$pageSize = 4;
$pageInfo = pageable("reply"," ArticleId=$id ",$pageIndex,$pageSize);
$replies = $pageInfo["items"];
$pageCount = $pageInfo["pageCount"];
$recordCount = $pageInfo["total"];

$isReplyOk=true;
$errorMsg;
if(isset($_POST["doReply"])){
    $content = $_POST["replyContent"];
    if(trim($content)===""){ $isReplyOk = false;$errorMsg ="请填写内容"; }
    $createTime = date_format(new DateTime(),'Y-m-d H:i:s');
    $authorId = $user["Id"];
    //z这里要做个判断，是否允许游客访问
    $authorName = $user["Username"];
    $articleId = $id;
    if($isReplyOk){
        $sql = "INSERT INTO `reply` values('','$content','$createTime','$authorId','$authorName','$articleId')";
        $conn -> query($sql);
        if ($conn->error) die($conn->error);
        $isReplyOk = true;
    }
}else $isReplyOk = true; 

require_once("header.inc.php");
?>
    <div class="dataset">
            <div class="field title">
                <label>标题</label>
                <div class="aa"><?=$detail["Title"]?></div>
            </div>
            <div class="field content">
                <label>内容</label>
                <div class="cc"><?=writeHtmlContent($detail["Content"])?></div>
            </div>
            <div class="info">
                <?=$detail["AuthorName"]?>编辑于<?=$detail["UpdateTime"]?>
            </div>
            <div class="actions">
                <a href="article_list.php">返回列表</a>
            </div>

            <div class="replies">
                <?php if(isset($isReplyOk) && $isReplyOk){ ?>
                    <div class="resultMsg">回复成功！</div>
                <?php }else{ ?>
                    <div style="color:red" class="errorMsg"><?=$errorMsg?></div>
                <?php } ?>

                <form class="replyEditor" action="article_detail.php?Id=<?=$id?>" method="POST">
                    <div class="caption">回复文章</div>
                    <textarea name="replyContent"></textarea>
                    <input type="submit" name="doReply" value="提交回复">
                </form>
                <div class="existedReplies">
                    <?php foreach($replies as $row){ ?>
                    <div class="replyBox">
                        <div class="replier"><?=$row["authorName"]?></div>
                        <div class="replyContent"><?=writeHtmlContent($row["content"])?></div>
                        <div class="replyTime"><?=$row["createTime"]?></div>
                    </div>
                    <?php } ?>
                    <div><?=$pageCount?>页, <?=$recordCount?>条回复< 
                    <?php for($i=1;$i<=$pageCount;$i++) {?>
                        <a href="article_detail.php?pageIndex=<?=$i?>&Id=<?=$id?>"><?=$i?></a>
                    <?php }?>
                     > </div>
                </div>
                <form class="replyEditor" >
                    <div>回复文章</div>
                    <textarea name="replyContent"></textarea>
                    <input type="submit" value="提交回复">
                </form>
            </div>

    </div>
<?php if(isset($_POST["doReply"])){ ?>
<script type="text/javascript">
    function scollBottom(){
        document.body.scrollTop = document.body.offsetHeight;
    }
    setTimeout(scollBottom, 100);

</script>
<?php } ?>

<?php require_once("footer.inc.php");?>