<?php 
ob_start();
session_start(); 
?>
<!DOCUMENT html>
<html>
<head>
<meta charset="gb2312">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1, maximum-scale=1, user-scalable=yes">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>���͹�����-��������</title>
<style type="text/css">
<!--
body,td,th {
	font-family: ����;
	font-size: 9pt;
	color: #222;
}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #FFFFFF;
	line-height:20px;
}
a:link {
	color: #222;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #222;
}
a:hover {
	text-decoration: underline;
	color: #FF0000;
}
a:active {
	text-decoration: none;
	color: #999999;
}
-->
</style>
<script>
    function del(id){
		if(confirm("ȷ��Ҫɾ����")){
			window.location='?id='+id;
			}
		}
</script>
<script language=javascript>
  function CheckPost()
 {

	if (myform.title.value.length<2)
	{
		alert("���ⲻ������2���ַ�");
		myform.title.focus();
		return false;
	}
	if (myform.name.value=="")
	{
		alert("�ǳƲ���Ϊ��");
		myform.name.focus();
		return false;
	}
	if (myform.content.value.length<10)
	{
		alert("���ݲ�������10���ַ�");
		myform.content.focus();
		return false;
	}
 }
</script>
<?php 
if($_POST['submit5']){
if($_POST['pwd']=="admin"){
$_SESSION['pwd']=$_POST['pwd'];
echo "<script language=javascript>alert('��½�ɹ���');window.location='feedback.php'</script>";
}
  }
?>
<?php
	if($_GET['tj'] == 'logout'){
	session_start(); //����session
	session_destroy();  //ע��session
	header("location:feedback.php"); //��ת����ҳ
	}
?>
<?php
if($_GET["id"]<>''){
$id = $_GET["id"];
$info = file_get_contents("info.txt");
$column = explode("@@@",$info); unset($column[$id]);
$noinfo = implode("@@@",$column);
    file_put_contents("info.txt",$noinfo);
	echo "<script language=javascript>alert('ɾ���ɹ���');window.location='feedback.php'</script>";
}
?>
</head>
<body>
<form  name="myform" method="post" onSubmit="return CheckPost()" action="" style="margin-bottom:5px;">
<table width="550" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td height="25" align="center" bgcolor="#EBEBEB"><a href="feedback.php">�鿴����</a>&nbsp;|&nbsp;<a href="feedback.php?tj=add">��������</a>&nbsp;|&nbsp;<?php if($_SESSION['pwd']==''){echo '<a href="feedback.php?tj=login">���Թ���</a>';}else{
echo "<a href='down.php'>���ݱ���</a>&nbsp;|&nbsp;<a href='feedback.php?tj=logout'>�˳�����</a>"; 
}?></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="5"></td>
  </tr>
</table>

<table width="550" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
<tr>
<th width="60" bgcolor="#EBEBEB">���Ա���</th>
<th width="76" bgcolor="#EBEBEB">���Ա���</th>
<th width="77" bgcolor="#EBEBEB">�����ǳ�</th>
<th width="133" bgcolor="#EBEBEB">��������</th>
<th width="78" bgcolor="#EBEBEB">����ʱ��</th>
<?php if($_SESSION['pwd']<>''){
echo "<th width='59' bgcolor='#EBEBEB'>����</th>";
}?>
</tr>
<?php
//���Ƿ�ҳ�ļ�
$info=file_get_contents("info.txt");
$info=explode("@@@",$info);

$page=(!empty($_GET['page'])) ? $_GET['page'] : 1;

$index=$page*5-5; //3 //6
$index2=$page*5-4; //4 //7
$index3=$page*5-3; //5 //8
$index4=$page*5-2; //6 //9
$index5=$page*5-1; //7 //10

$infos=$info[$index]."@@@".$info[$index2]."@@@".$info[$index3]."@@@".$info[$index4]."@@@".$info[$index5];

//ͳ��ҳ��
$infoc=file_get_contents("info.txt");
$cont=substr_count($infoc,"@@@")/5;
//echo $cont;
//print_r($infos);
//$infos=strpos($info,'@@@',2);

if(strlen($infos)>10){
$column = explode("@@@",$infos);

//ɾ�������ֵ
foreach( $column as $k=>$v){
if( !$v )
unset( $column[$k] );
}

foreach($column as $keys=>$values){
$message = explode("%%",$values);
?>
<tr>
<td align="center" bgcolor="#FFFFFF"><img src="face/pic<?php echo $message[2];?>.gif" width="20" height="20" /></th>
<td align="center" bgcolor="#FFFFFF"><?php echo $message[0];?>
</th>
</td>
<td align="center" bgcolor="#FFFFFF"><?php echo $message[1];?></th>
<td align="center" bgcolor="#FFFFFF"><?php echo $message[3];?></th>
<td align="center" bgcolor="#FFFFFF"><?php echo date("m/d H:i",$message[4]);?>
</th>
<?php if($_SESSION['pwd']<>''){
$pages=$keys+($page*5-5);
echo "<td align='center' bgcolor='#FFFFFF'>";
echo "<a href='javascript:del({$pages})'>ɾ��</a>";
echo "</th>";
}?>
</tr>
<?php
	}
}
?>
</table>

<table width="100" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="5"></td>
  </tr>
</table>
<table width="550" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td align="center" bgcolor="#FFFFFF"><?php 
$linkstr="";
for($i=0;$i<$cont;$i++)
{
    $linkstr.= "<a href=?page=".($i+1).">��".($i+1)."ҳ</a>";
}
echo $linkstr; 
?></td>
  </tr>
</table>

<table width="100" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="5"></td>
  </tr>
</table>
<?php 
if($_GET["tj"] == add){
?>
<?php
if($_POST[submit]){
$title = $_POST["title"];
$name = $_POST["name"];
$face = $_POST["face"];
$content = $_POST["content"];
$addtime = time();
$insert = "{$title}%%{$name}%%{$face}%%{$content}%%{$addtime}@@@";
$content = file_get_contents("info.txt");
           file_put_contents("info.txt",$content.$insert);
		   echo "<script language=javascript>alert('���Գɹ���');window.location='feedback.php'</script>";
	}
?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td height="5"></td>
    </tr>
  </table>
  <table width="550" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3" brder="1">
<tr>
    <td width="62" align="center" bgcolor="#FFFFFF">���Ա��⣺</td>
    <td width="465" bgcolor="#FFFFFF"><input type="text" name="title"/>
      &nbsp;*</td>
</tr>
<tr>
     <td align="center" bgcolor="#FFFFFF">�����ǳƣ�</td>
     <td bgcolor="#FFFFFF"><input name="name" type="text" id="name"/> 
       &nbsp;*</td>    
</tr>
<tr>
  <td align="center" bgcolor="#FFFFFF">���ѱ��飺</td>
  <td bgcolor="#FFFFFF"><input type="radio" value="1" name="face" checked="checked" />
                            <img src="face/pic1.gif" width="20" height="20" border="0" />
                            <input type="radio" value="2" name="face" />
                            <img src="face/pic2.gif" width="20" height="20" border="0" />
                            <input type="radio" value="3" name="face" />
                            <img src="face/pic3.gif" width="20" height="20" border="0" />
                            <input type="radio" value="4" name="face" />
                            <img src="face/pic4.gif" width="20" height="20" border="0" />
                            <input type="radio" value="5" name="face" />
                            <img src="face/pic5.gif" width="20" height="20" border="0" />
                            <input type="radio" value="6" name="face" />
                            <img src="face/pic6.gif" width="20" height="20" border="0" />
                            <input type="radio" value="7" name="face" />
                            <img src="face/pic7.gif" width="20" height="20" border="0" /></td>
</tr>
<tr>
     <td align="center" bgcolor="#FFFFFF">�������ݣ�</td>
     <td bgcolor="#FFFFFF"><textarea name="content" rows="5" cols="40"></textarea>
      &nbsp;��������10���ַ�</td>
</tr>
<tr>
      <td colspan="2" align="center" bgcolor="#FFFFFF">
        <input name="submit" type="submit"value="�ύ" />&nbsp;&nbsp; 
        <input name="reset" type="reset"  value="����"/>      </td>
    </tr>
</table>
</form>
<?php 
	}
?>
<?php if($_GET['tj'] == 'login'){ ?>
<form  name="form" method="post" action="" style=" margin-top:5px;">
 <table width="550" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td colspan="3" align="center" bgcolor="#EBEBEB" class="font">��̨����ҳ</td>
    </tr>
  <tr>
    <td width="89" align="center" bgcolor="#FFFFFF" class="font">��������:</td>
    <td colspan="2" bgcolor="#FFFFFF" class="font">
      <input name="pwd" type="text" id="pwd" size="16"/></td>
    </tr>
    <tr>
    <td colspan="3" align="center" valign="top" bgcolor="#FFFFFF" class="font">
    <input type="submit" name="submit5" value="��¼" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" name="reset"  value="����" /></td>
    </tr>
</table>
 <table width="100" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td height="5"></td>
   </tr>
 </table>
</form>
<?php } ?>
<table width="550" height="20" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
  <tr>
    <td align="left" bgcolor="#FFFFFF">&nbsp;Copyright @ 2013-2113 ���͹�����  ALL Rights Reserved</td>
  </tr>
</table>
</body>
</html>