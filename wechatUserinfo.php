<?php
session_start();

//��Ҫ���ص������ֶ�
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
*  1.������תҳ��֮���ȡ����code
*  2.��ȡaccess_token
*  3.��ȡ�û���Ϣ
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
    $state1 = $_GET["state"]; //��ȡwechat�������ṩ��state��Ϣ
    $code   = $_GET["code"];    //��ȡwechat�������ṩ��code��
}



/////////////////////////////////////////////////////
require_once 'Wechat.php';
$wechat = new Wechat();
//////////////////////////////////////////////////////
//��ȡaccess_token
$token_data = $wechat->get_access_token($code);

if($token_data == false)
{
    $msg = 'access_token failed';	
    $status = '1';
    $data = '';
    $dataall = array('status'=>$status,'data'=>$data,'msg'=>$msg);
    echo $dataall;
    exit('��ȡaccess_tokenʧ��');
}

$access_token = $token_data['access_token'];
$openid = $token_data['openid'];


//echo $access_token; 
//echo $openid;
//
////////////////////////////////////////////////////////
//��ȡ�û���Ϣ
$info_data = $wechat->get_user_info($access_token,$openid);

if($info_data == false)
{
    $msg = 'useinfo failed';	
    $status = '1';
    $data = ('');
    $dataall = array('status'=>$status,'data'=>$data,'msg'=>$msg);
    echo $dataall;
    exit('��ȡuserinfoʧ��');
}

$openid   = $info_data['openid'];
$nickname = $info_data['nickname'];

$_SESSION['openid'] = $openid;
$_SESSION['nickname'] = $nickname;

/////////////////////////////////////////////////////////
//�û����ڹ���


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
