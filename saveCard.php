<?php
 session_start();                  //获取session
 /**********************************************
  * 将数据保存先来存储到数据库
  *********************************************/

if(!isset($_SESSION["nickname"])|| empty($_SESSION["nickname"]))
{
        $status = '1';
	$msg = '没有认证';
	$url = 'localhost';  //需要改
	$data = array('status'=>'1','msg'=>$msg);
        post_2_url($url,$data);
        exit;	
}

$openid  = test_input($_SESSION['openid']);
$nickname = test_input($_SESSION['nickname']);

////////////////////////////////////////
//获取用户操作
$savecard = test_input($_POST['cardId']);


////////////////////////////////////////
include('conn.php');
//检测是否存在
$check_query = mysql_query("select * from test_savecard where w_id='$openid'");

//如果存在插入计算
if($result = mysql_fetch_array($check_query))
{ 
	$sql = " UPDATE test_savecard SET savecard = '$savecard' WHERE w_id='$openid'"; 
}
else 
{
	$sql = "INSERT INTO test_savecard(w_id,w_name,savecard)VALUES('$openid','$nickname','$savecard')"; 
}

if(mysql_query($sql))
{
	$status = '0';
	$msg = '';
	$url = 'localhost';
}
else 
{
        $status = '1';
	$msg = '存储失败!';
	$url = 'localhost';
}
//////////////////////////////////////////////////////
   $data = array('status'=>'0','msg'=>$msg);
   post_2_url($url,$data);
   exit;
///////////////////////////////////////////////////////

function test_input($data) 
  {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}


function post_2_url($url,$data)
{
     $data_all = json_encode($data);
     echo $data_all; 
     http_post_data($url,$data_all);
}

function http_post_data($url, $data_string) 
{    
        $ch = curl_init();  
        curl_setopt($ch, CURLOPT_POST, 1);  
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
            'Content-Type: application/json; charset=utf-8',  
            'Content-Length: ' . strlen($data_string))  
        );  
        ob_start();  
        curl_exec($ch);  
        $return_content = ob_get_contents();  
        ob_end_clean();  
  
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
        return array($return_code, $return_content);  
}
?>
