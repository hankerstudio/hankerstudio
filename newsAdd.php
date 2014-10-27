<?php
include("top.php");
include("HKtxtDB.class.php");
$cls = new HKtxtDB('./hkDB/newsclass.txt');
$row = $cls->select(array('parentId'=>0));
?>
<div class="subtitle"><span>〉</span>添加新闻</div>
<div class="news">
  <div class="newsInfo">
    <form action="newsAddSave.php" method="post">
    <div>类别选择：<select name="classId">
    <?php foreach($row as $v){?>
      <option value="<?php echo $v['classId'];?>"><?php echo $v['className'];?></option>
    <?php }?>
    </select></div>
    <div>标题：</div>
    <div><input type="text" name="title" style="width:100%;"></div>
    <div>内容：</div>
    <div style="pading:2%;"><textarea name='content' style="width:100%;height:200px;"></textarea></div>
    <div><input type="submit" value="确定添加" /></div>
    </form>
  </div>
</div>
<?php include("foot.php");?>