<?php

/*****************************
*���ݿ������
*****************************/
/*
 * if(!isset($_SESSOIN["data"])||empty($_SESSOIN["data"]))
{
     $status = '1';
     $msg = 'û����֤';
     $data = '';
     $_SESSION['data'] = $data;
     $_SESSION['msg']  = $msg;
     $_SESSION['status'] = $status;     
     exit;	
}
*/
$servername = 'localhost';
$username = 'root';
$password = '123333';

$conn = @mysql_connect($servername,$username,$password);
if (!$conn){
	die("ERROR!" . mysql_error());
}

$conndb = mysql_select_db("test", $conn);

/*
if($conndb == true)
{
   echo 'the db is open!';
}
 */

//�������ݿ���������
mysql_query("set character set 'gbk'");
//
mysql_query("set names 'gbk'");
?>
