<?php
include("top.php");
include("HKtxtDB.class.php");
$db = new HKtxtDB('./hkDB/news.txt');
$row = $db->select(array('ID'=>(int)$_GET['id']));
$rsv = $row[0];
?>
<div class="subtitle"><span>〉</span><a href='index.php'>首页</a> > 新闻中心 > 详细内容</div>
<div class="news">
  <div class="newsInfo">
    <a><?php echo $rsv['title'];?></a><br>
    <span><?php echo $rsv['content'];?></span>
  </div>
</div>
<?php include("foot.php");?>