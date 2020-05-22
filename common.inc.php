<?php
session_start();
//当前用户
$user = isset($_SESSION["user"])?$_SESSION["user"]:null;
$userId = $user?$user["id"]:null;

//数据库
function createDb(){
    $conn = new mysqli("localhost","root","root","php");
    return $conn;
}

function pageURL($pageIndex){
    $pageString = "pageIndex=$pageIndex";
    foreach ($_GET as $k => $v) {
        if($k==="pageIndex") continue;
        $pageString .="&$k=$v";
    }
    return $pageString;
}
function getParam($name){
    $value = isset($_GET[$name])?$_GET[$name]:null;
    $value = str_replace("'","''",$value);
    return $value;
}
//分页函数
function pageable($tbname,$where,$pageIndex,$pageSize){
    $start = ($pageIndex-1)*$pageSize;
    $conn = createDb();
    $itemsSql = "SELECT * FROM `$tbname` " ; 
    if($where) $itemsSql.=" WHERE ".$where;
    $itemsSql.= " ORDER BY `CreateTime` desc LIMIT $start,$pageSize ";
    $rs = $conn->query($itemsSql);
    if ($conn->error) die($conn->error);
    $items =[];
    while($record = $rs->fetch_assoc()){
        $items[]=$record;
    }
    $rs->close();

    $countSql = "SELECT count(*) as c FROM `$tbname` ";
    if($where) $countSql.=" WHERE ".$where;
    $rs = $conn->query($countSql);
    $total = $rs->fetch_assoc()["c"];
    $rs->close();
    $pageCount = ceil($total/$pageSize);

    return [
        "items"=>$items,
        "total"=>$total,
        "pageCount"=>$pageCount
    ];

}