<?php
//����ʵ�ֵ��ǻ�ȡ��wechat����Ȩ��½��������תҳ�棬��ȡ�û�����Ϣ
session_start();                //��ʼ��session

   
if(!isset($_POST["url"]))
{
    $msg = 'access_token failed';	
    $status = '1';
    $data = '';
    $dataall = array('status'=>$status,'data'=>$data,'msg'=>$msg);
    echo $dataall; 
    exit('Error!')
}

//��ȡwechat��֤Ȩ��
require_once('Wechat.php');
$wechat = new Wechat();    // ��������

$redurect_uri = $_POST['url'];//'http://wxshare.charmingnet.com';  //��ת��ҳ�� //$_POST['url'];  //


$state0 = MD5(rand(10,100));        //��ȡ�����״̬
$state1 = '';                  //��Ȩ��֤֮�����state
$code = '';                    //��Ȩ�ķ���code

$_SESSION['state0'] = $state0;  //��state��״̬��Ϣ���浽session��
$_SESSION['url'] = $redurect_uri; 

header("Location:".$redurect_uri);

?>
