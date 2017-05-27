<?php
session_start();

//需要返回的三个字段
$msg = '';
$status = '';
$data = '';

if(!isset($_SESSION["state0"]))
{
	$msg = 'Error';
	$status = '1';
	$data = '';
        $dataall = array('status'=>$status,'data'=>$data,'msg'=>$msg);
        echo $dataall;
	exit("ERROR");
}

$url = $_SESSION['url'];

/*
*  1.这里跳转页面之后获取到，code
*  2.获取access_token
*  3.获取用户信息
*/


if(!isset($_GET["code"]))
{ 
     $msg     = 'author error';
     $status  = '1';
     $data    = '';
     $dataall = array('status'=>$status,'data'=>$data,'msg'=>$msg);
     echo $dataall;
     exit('Author Failed!');
}
else
{
    $state1 = $_GET["state"]; //获取wechat服务器提供的state信息
    $code   = $_GET["code"];    //获取wechat服务器提供的code信
}



/////////////////////////////////////////////////////
require_once 'Wechat.php';
$wechat = new Wechat();
//////////////////////////////////////////////////////
//获取access_token
$token_data = $wechat->get_access_token($code);

if($token_data == false)
{
    $msg = 'access_token failed';	
    $status = '1';
    $data = '';
    $dataall = array('status'=>$status,'data'=>$data,'msg'=>$msg);
    echo $dataall;
    exit('获取access_token失败');
}

$access_token = $token_data['access_token'];
$openid = $token_data['openid'];


//echo $access_token; 
//echo $openid;
//
////////////////////////////////////////////////////////
//获取用户信息
$info_data = $wechat->get_user_info($access_token,$openid);

if($info_data == false)
{
    $msg = 'useinfo failed';	
    $status = '1';
    $data = ('');
    $dataall = array('status'=>$status,'data'=>$data,'msg'=>$msg);
    echo $dataall;
    exit('获取userinfo失败');
}

$openid   = $info_data['openid'];
$nickname = $info_data['nickname'];

$_SESSION['openid'] = $openid;
$_SESSION['nickname'] = $nickname;

/////////////////////////////////////////////////////////
//用户用于共享


/*Sat May 27 11:30:55 CST 2017*/
require_once('JSSDK.php');
$app_id = 'ww7163d30cc3b0bd5d';
$app_secret = '6e91a9be55a0be3398813aaabb3b444e';

$jssdk = new JSSDK($app_id,$app_secret);
$signPackage = array("appId"=>$app_id,"nonceStr"=>'abcde',"timestamp"=>'123',"signature"=>'321');
$signPackage = $jssdk->GetSignPackage(); 
$data = array('status'=>'0','data'=>$signPackage,'msg'=>'');
echo $dataall;
$url = $url.'?userId='.$openid;
header("Location".$url);
exit;


?>
