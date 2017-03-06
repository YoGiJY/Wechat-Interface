<?php
  
/**
 * ΢����Ȩ��ؽӿ�
 */
  
class Wechat {
   
  //�߼�����-��������ģʽ-����ȡ
  private $app_id = 'wx7163d30cc3b0bd5d';
  private $app_secret = '5e91a9be55a0be3398813aaabb3b444e';
  
  /**
   * ��ȡ΢����Ȩ����
   * 
   * @param string $redirect_uri ��ת��ַ
   * @param mixed $state ����
   */
  public function get_authorize_url($redirect_uri = '', $state = '')
  {
    $redirect_uri = urlencode($redirect_uri);
    return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->app_id}&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state={$state}#wechat_redirect";
  }
   
  /**
   * ��ȡ��Ȩtoken
   * 
   * @param string $code ͨ��get_authorize_url��ȡ����code
   */
  public function get_access_token( $code = '')
  {
    $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->app_id}&secret={$this->app_secret}&code={$code}&grant_type=authorization_code";
    $token_data = $this->http($token_url);

    if($token_data[0] == 200)
    {
	    return json_decode($token_data[1], TRUE);
    }
     
    return FALSE;
  }
   
  /**
   * ��ȡ��Ȩ���΢���û���Ϣ
   * 
   * @param string $access_token
   * @param string $open_id
   */
  public function get_user_info($access_token = '', $open_id = '')
  {
   if($access_token && $open_id)
    {
      $info_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
      $info_data = $this->http($info_url);
      if($info_data[0] == 200)
      {
        return json_decode($info_data[1], TRUE);
      }
    }
    return FALSE;
  }
   
  public function http($url)
  {
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ci, CURLOPT_TIMEOUT, 30);
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ci, CURLOPT_URL, $url);
    curl_setopt($ci, CURLINFO_HEADER_OUT, true);
  
    $response = curl_exec($ci);
    $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    curl_close($ci);
    return array($http_code, $response);
   }
}

?>
