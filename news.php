<?php
include("top.php");
include("HKtxtDB.class.php");
$db = new HKtxtDB('./hkDB/news.txt');
$cls = new HKtxtDB('./hkDB/newsclass.txt');
$clsRow = $cls->select(array('parentId'=>0));
$page = (int)$_GET['page'];
$cid = (int)$_GET['cid'];
$arr = null;
if($cid!=0){
  $row = $cls->select(array('classId'=>$cid));
  $ttl = ' > '.$row[0]['className'];
  $arr = array();
  $arr['classId'] = $cid;
}
$count = $db->file_line_count($arr);
if($page==0)$page=1;
$page_size = 5;
$news = $db->file_read(($page-1)*$page_size,$page_size,'desc',$arr);
$page_str = showpage($count,$page,$page_size,'?cid='.$cid);
function showpage($count,$page,$page_size,$url){
  $str = '';
  $ttl = ($count % $page_size)==0?($count/$page_size):((int)($count/$page_size)+1);
  $ps = ($page-2)<1?1:($page-2);
  $pe = ($page+2)>$ttl?$ttl:($page+2);
  for($i=$ps;$i<=$pe;$i++){
    $str.='<a href="'.$url.'&page='.$i.'"'.($i==$page?' class="sel"':'').'>'.$i.'</a> ';
  }
  return $str;
}
?>
<div class="func">
  <a href="index.php">返回首页</a>
  <?php foreach($clsRow as $row){?>
  <a href="news.php?cid=<?php echo $row['classId'];?>"><?php echo $row['className'];?></a>
  <?php }?>
</div>
<div class="subtitle"><span>〉</span>新闻中心<?php echo $ttl;?></div>
<div class="news">
<?php
foreach($news as $v){
?>
  <div class="newsInfo">
    <a href="newsInfo.php?id=<?php echo $v['ID'];?>"><?php echo $v['title'];?><br>
    <span><?php echo substr($v['content'],0,200);?></span>
    </a>
  </div>
<?php }?>
<style>
.page a{display:inline-block;padding:0 10px;background:#E2ECFE;border:1px solid #91B9FF;}
.page a.sel{background:#fafafa;border:1px solid #eee;}
</style>
  <div class="newsInfo page" align=center><?php echo $page_str;?></div>
</div>
<?php include("foot.php");?>