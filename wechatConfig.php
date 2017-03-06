<?php
//这里实现的是获取，wechat的授权登陆，并且跳转页面，获取用户的信息
session_start();                //初始化session

   
if(!isset($_POST["url"]))
{
    $msg = 'access_token failed';	
    $status = '1';
    $data = '';
    $dataall = array('status'=>$status,'data'=>$data,'msg'=>$msg);
    echo $dataall; 
    exit('Error!')
}

//获取wechat认证权限
require_once('Wechat.php');
$wechat = new Wechat();    // 创建对象

$redurect_uri = $_POST['url'];//'http://wxshare.charmingnet.com';  //跳转的页面 //$_POST['url'];  //


$state0 = MD5(rand(10,100));        //获取随机数状态
$state1 = '';                  //授权认证之后给的state
$code = '';                    //授权的反馈code

$_SESSION['state0'] = $state0;  //将state的状态信息保存到session中
$_SESSION['url'] = $redurect_uri; 

header("Location:".$redurect_uri);

?>
