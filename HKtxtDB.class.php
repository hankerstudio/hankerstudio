<?php
//˵�������ı����ݿ�ֻ֧��ID����������򣨼�˳���ȡ�뵹���ȡ�ı�),���м�¼����JSON��ʽ����
//ÿ�������ܶ���һ��������������ID������Ψһֵ�ֶΣ��Բ������ʵĺܴ��������а���
//ʾ����news.txt�ļ���������һ�����ݸ�ʽ��
//{"newsID":1,"classID":2,"newsTitle":"�ı����ݿ�������","newsContent":"��ӭʹ���ı����ݿ��ࡣ����","addDate":"2014-09-10 13:34:19"}
class HKtxtDB {

  public $db; //���ݿ��ļ�
  public $lines; //���ݿ��¼�����ļ�������
  
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
  
  public function select($arr,$type=1){//֧�ֶ�������ѯ, ��ȷ����
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

  public function delete($arr){//��ȷɾ��
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
      $fp = fopen( $this->db, 'a' ); //��ֻдģʽ��banklist.txt�ı��ļ�,�ļ�ָ��ָ���ļ�β��. 
      fwrite ( $fp, chr(13).chr(10).$str ); //������д���ļ� 
      fclose ( $fp ); //�ر��ļ� 
      return true;
    } catch( Exception $e) {
      return false;
    }
  }
 
  public function file_read($pos,$n,$orderType,$arr=null) {//�ӵ�$pos�п�ʼ��ȡ�ı�N�У��������
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
    $line = 0 ; //��ʼ������  
    $fp = fopen($this->db , 'r') or die("open file failure!");   //���ļ�
    if($fp){
      while(fgets($fp)){  //��ȡ�ļ���һ������
        $line++;
      }
      fclose($fp);//�ر��ļ�
    }
    return $line; 
  }
}

//ʹ��ʾ��
//$db = new HKtxtDB('./hkDB/news.txt');
//print_r($db->file_read(0,5,'desc',array('classId'=>2)));