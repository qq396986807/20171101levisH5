<?php
/**
 * Created by PhpStorm.
 * User: createc
 * Date: 2017/10/25
 * Time: 上午11:49
 */
$u_r_l = $_POST['url'];
function adapterInterface($interface = '', $post_data = array())
{
    $post_data['req_time'] = time();
    $post_data['client_code'] = 'ouhegARUGNOJyYO5nTobqYRWkAEIPo1b';
    $tmp_data = $post_data;
    $tmp_data['client_secret'] = '7dFcxQr2c0X08LerNn5fVAm5SB84H9Ft';
    ksort($tmp_data);
    $tmp_str = '';
    foreach ($tmp_data as $v) {
        if (!is_array($v)) {
            $tmp_str .= $v;
        } }
    $auth_code = md5($tmp_str);
    $url = "http://hiproapi.verystar.cn/" . $interface . "?authcode=" . $auth_code
    ;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    if ($post_data) {
        curl_setopt($curl, CURLOPT_POST, 1);
        $post_data = http_build_query($post_data);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
    }
    $ret = curl_exec($curl);
    return json_decode($ret, true);
}
$post_data = array(
    'redirect_uri'  => $u_r_l,
    'oauth_type'  => 'oauth_snsapi_openid'
);
$interface = 'weixinapi/set_drawboard_data';
$a = adapterInterface($interface,$post_data);
//print_r(adapterInterface($interface, $post_data));
echo $a['data']['redirect'];
