<?php
header("Content-type: text/html; charset=utf-8");
include("HKtxtDB.class.php");
$db = new HKtxtDB('./hkDB/news.txt');
$news = $db->file_read(0,1,'desc');
if($news){
  $rsv = $news[0];
  $id = $rsv['ID'] + 1;
}else{
  $id = 1;
}
$data['ID'] = $id;
$data['classId'] = (int)$_POST['classId'];
$data['title'] = $_POST['title'];
$data['content'] = str_replace(chr(13).chr(10),'<br>',$_POST['content']);
$data['addDate'] = date('Y-m-d H:i:s');
$db->insert('{"ID":'.$data['ID'].',"classId":'.$data['classId'].',"title":"'.$data['title'].'","content":"'.$data['content'].'","addDate":"'.$data['addDate'].'"}');
header('Location:index.php');
?>