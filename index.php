<?php
include("top.php");
include("HKtxtDB.class.php");
$db = new HKtxtDB('./hkDB/news.txt');
$news = $db->file_read(0,5,'desc');
?>
<div class="func">
  <a href="about.php">公司简介</a>
  <a href="news.php">新闻中心</a>
  <a href="feedback/feedback.php">留言板</a>
</div>
<div class="subtitle"><span>〉</span>新闻中心</div>
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
</div>
<?php include("foot.php");?>