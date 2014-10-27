<?php
//说明：此文本数据库只支付ID正序或倒序排序（即顺序读取与倒序读取文本),所有记录均以JSON格式存入
//每个表尽可能都做一个主键，像自增ID这样的唯一值字段，对操作速率的很大提升很有帮助
//示例：news.txt文件（表）其中一行数据格式：
//{"newsID":1,"classID":2,"newsTitle":"文本数据库上线啦","newsContent":"欢迎使用文本数据库类。。。","addDate":"2014-09-10 13:34:19"}
class HKtxtDB {

  public $db; //数据库文件
  public $lines; //数据库记录数（文件行数）
  
  public function __construct($db) {
    $this->db = $db;
    $this->lines = $this->file_line_count();
  }
  
  public function insert($jsonStr) {
    if($this->file_write($jsonStr)){
      $this->lines++;
      return true;
    }else{
      return false;
    }
  }
  
  public function select($arr,$type=1){//支持多条件查询, 精确查找
    if(!$arr){return null;}
    $row = array();
    $fp = fopen( $this->db, 'r' );
    while(!feof($fp)){
      $str = fgets($fp);
      $rst = true;
      foreach($arr as $k=>$v){
        $rst = $rst && (stripos($str,'"'.$k.'":'.json_encode($v))!==false);
      }
      if($type){$str=json_decode($str,true);}
      if($rst){
        array_unshift($row,$str);
      }
    }
    return $row;
  }

  public function delete($arr){//精确删除
    $row = $this->select($arr,0);
    $fp = file_get_contents($this->db);
    if($row){
      foreach($row as $v){
        $fp = str_replace($v, '', $fp);
      }
    }
    file_put_contents($this->db, $fp);
  }
  
  public function modify($newJsonStr,$oldJsonStr){
    $fp = file_get_contents($this->db);
    $fp = str_replace($newJsonStr,$oldJsonStr,$fp);
    file_put_contents($this->db, $fp);
  }
  
  public function file_write($str){
    try {
      $fp = fopen( $this->db, 'a' ); //以只写模式打开banklist.txt文本文件,文件指针指向文件尾部. 
      fwrite ( $fp, chr(13).chr(10).$str ); //将数据写入文件 
      fclose ( $fp ); //关闭文件 
      return true;
    } catch( Exception $e) {
      return false;
    }
  }
 
  public function file_read($pos,$n,$orderType,$arr=null) {//从第$pos行开始读取文本N行，倒序输出
    $lines = array();
    $posn = 0;
    if($arr==null){
      if($this->lines<$pos||$pos<0){return null;}
      if(strtolower($orderType)=='desc'){
        $pos = $this->lines - $pos;
        if($pos<0){return null;}
        elseif($pos<$n){$n=$pos;$pos = 0;}
        else{$pos = $pos - $n;}
      }
      $fp = fopen( $this->db, 'r' );
      while(!feof($fp)){
        $str = fgets($fp);
        $str = json_decode($str,true);
        if(++$posn>$pos && count($lines)<$n){
          if($orderType=='desc'){
            array_unshift($lines,$str);
          }else{
            $lines[] = $str;
          }
        }
      }
    }else{
      $row = $this->select($arr);
      $rowLen = count($row);
      if($rowLen<$pos||$pos<0){return null;}
      if(strtolower($orderType)=='desc'){
        $pos = $rowLen - $pos;
        if($pos<0){return null;}
        elseif($pos<$n){$n=$pos;$pos = 0;}
        else{$pos = $pos - $n;}
      }
      foreach($row as $v){
        $str = $v;
        if(++$posn>$pos && count($lines)<$n){
          if($orderType=='desc'){
            array_unshift($lines,$str);
          }else{
            $lines[] = $str;
          }
        }
      }
    }
    return $lines;
  }
  
  public function file_line_count($arr=null){
    if($arr){
      $row = $this->select($arr,0);
      return count($row);
    }
    $line = 0 ; //初始化行数  
    $fp = fopen($this->db , 'r') or die("open file failure!");   //打开文件
    if($fp){
      while(fgets($fp)){  //获取文件的一行内容
        $line++;
      }
      fclose($fp);//关闭文件
    }
    return $line; 
  }
}

//使用示例
//$db = new HKtxtDB('./hkDB/news.txt');
//print_r($db->file_read(0,5,'desc',array('classId'=>2)));