<?php
/**
 * Created by PhpStorm.
 * User: createc
 * Date: 2017/10/25
 * Time: 下午1:30
 */
header("Content-type: text/html; charset=utf-8");
//$host = 'bdm253827566.my3w.com';//数据库ip
//$user = 'bdm253827566';//数据库user
//$pwd = 'a1237777';//数据库密码
//$dbname = 'bdm253827566_db';//数据库名称
$host = 'localhost';//数据库ip
$user = 'levis';//数据库user
$pwd = 'levis';//数据库密码
$dbname = 'levis';//数据库名称
$port = '3306';//端口
$link = mysqli_connect($host,$user,$pwd,$dbname,$port);
$time = date("Y-m-d H:i:s",time());

//授权的函数
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

$key = $_POST['key'];
if(isset($key)){
    $post_data = array(
        'key'  => $key
    );
    $interface = 'weixinapi/get_user_data';
    echo json_encode(adapterInterface($interface, $post_data));
}



//短信发送
$phone = $_POST['phone'];
if(isset($phone)) {
    $msg = testSingleMt($phone);
    $url = 'http://agileapi.10690007.net/proxysms/mt?command=MT_REQUEST&spid=100638&sppassword=Re8TkdQb&sa=11&spsc=00&da=86' . $phone . '&dc=15&sm=' . $msg;
    function get_url($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);  //设置访问的url地址
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//不输出内容
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    get_url($url);
}

//验证短信是否正确
$phone2 = $_POST['phone2'];
$yzm = $_POST['yzm'];
if(isset($yzm)){
    if($_COOKIE[$phone2] == $yzm){
        echo 1;
    }else{
        echo 0;
    }
}


//分数存储
$nick = $_POST['nick'];
$moble = $_POST['moble'];
$point = $_POST['score'];
if(isset($nick)){
    $res = mysqli_query($link,"select * from levis_user where Nick = '{$nick}';");
    $num_rows = mysqli_num_rows($res);
    $row=mysqli_fetch_array($res);
    if($num_rows==0){
        $res = mysqli_query($link,"insert into levis_user (Nick,Point,upTime) values('{$nick}','{$point}','{$time}');");//存入数据库
    }else{
        if($point>$row['Point']){
            $res = mysqli_query($link,"UPDATE levis_user SET Point = '{$point}' WHERE Nick = '{$nick}';");
        }
    }
}

if(isset($moble)){
    $res = mysqli_query($link,"select * from levis_user where Moble = '{$moble}';");
    $num_rows = mysqli_num_rows($res);
    $row=mysqli_fetch_array($res);
    if($num_rows==0){
        $res = mysqli_query($link,"insert into levis_user (Moble,Point,upTime) values('{$moble}','{$point}','{$time}');");//存入数据库
    }else{
        if($point>$row['Point']){
            $res = mysqli_query($link,"UPDATE levis_user SET Point = '{$point}' WHERE Moble = '{$moble}';");
        }
    }
}


//排行榜的显示
$phb = $_POST['phb'];
if($phb){
    $res = mysqli_query($link,"select * from levis_user ORDER BY `Point` DESC LIMIT 10;");
    $ary = array();
    while ($bookInfo = mysqli_fetch_array($res)){ //返回查询结果到数组
            array_push($ary,$bookInfo);
    }
    echo json_encode($ary);
}

//一进来显示分数
$mob = $_POST['mob'];
if(isset($mob)){
    $res = mysqli_query($link,"select * from levis_user where Moble = '{$mob}';");
    $row=mysqli_fetch_array($res);
    echo $row['Point'];
}

$name = $_POST['name'];
if(isset($name)){
    $res = mysqli_query($link,"select * from levis_user where Nick = '{$name}';");
    $row=mysqli_fetch_array($res);
    echo $row['Point'];
}

function testSingleMt($phone) {
    $dc = "15";
    $num = rand(100000,999999);
    setcookie($phone,$num,time()+600);
    $sm = '您的验证码:'.$num.'(10分钟内有效)';
    $request=encodeHexStr($dc,$sm);//下发内容转换HEX编码
    return $request;
}

function doGetRequest($host,$port,$request) {
    $httpGet  = "GET ". $request. " HTTP/1.1\r\n";
    $httpGet .= "Host: $host\r\n";
    $httpGet .= "Connection: Close\r\n";
    //	$httpGet .= "User-Agent: Mozilla/4.0(compatible;MSIE 7.0;Windows NT 5.1)\r\n";
    $httpGet .= "Content-type: text/plain\r\n";
    $httpGet .= "Content-length: " . strlen($request) . "\r\n";
    $httpGet .= "\r\n";
    $httpGet .= $request;
    $httpGet .= "\r\n\r\n";
    return httpSend($host,$port,$httpGet);
}

function doPostRequest($host,$port,$request) {
    $content = substr($request,1+stripos($request,"?"));
    $httpPost  = "POST ". substr($request,0,stripos($request,"?")). " HTTP/1.1\r\n";
    $httpPost .= "Host: $host\r\n";
    $httpPost .= "Connection: Close\r\n";
    //	$httpPost .= "User-Agent: Mozilla/4.0(compatible;MSIE 7.0;Windows NT 5.1)\r\n";
    $httpPost .= "Content-type: application/x-www-form-urlencoded\r\n";
    $httpPost .= "Content-length: " . strlen($content) . "\r\n";
    $httpPost .= "\r\n";
    $httpPost .= $content;
    $httpPost .= "\r\n\r\n";
    return httpSend($host,$port,$httpPost);
}
/**
 * 使用http协议发送消息
 *
 * @param string $host
 * @param int $port
 * @param string $request
 * @return string
 */
function httpSend($host,$port,$request) {
    $result = "";
    $fp = @fsockopen($host, $port,$errno,$errstr,5);
    if ( $fp ) {
        fwrite($fp, $request);
        while(! feof($fp)) {
            $result .= fread($fp, 1024);
        }
        fclose($fp);
    }
    else
    {
        return "连接短信网关超时！";//超时标志
    }
    list($header, $foo)  = explode("\r\n\r\n", $result);
    list($foo, $content) = explode($header, $result);
    $content=str_replace("\r\n","",$content);
    //返回调用结果


    return $content;
}

/**
 * encode Hex String
 *
 * @param string $dataCoding
 * @param string $binStr
 * @param string $encode
 * @return string hex string
 */
function encodeHexStr($dataCoding,$binStr,$encode="UTF-8"){
    //return bin2hex($binStr);
    if ($dataCoding == 15) {//GBK
        return bin2hex(mb_convert_encoding($binStr,"GBK",$encode));
    } elseif (($dataCoding & 0x0C) == 8) {//UCS-2BE
        return bin2hex(mb_convert_encoding($binStr,"UCS-2BE",$encode));
    } else {//ISO8859-1
        return bin2hex(mb_convert_encoding($binStr,"ASCII",$encode));
    }
}

/**
 *  decode Hex String
 *
 * @param string $dataCoding
 * @param string $hexStr
 * @param string $encode
 * @return string binary string
 */
function decodeHexStr($dataCoding,$hexStr,$encode="GBK"){
    // only hex numbers is allowed
    if (strlen($hexStr) % 2 != 0 || preg_match("/[^\da-fA-F]/",$hexStr)) return FALSE;

    $buffer=array();
    if ($dataCoding == 15) {//GBK
        for($i=0;$i<strlen($hexStr);$i+=2){
            if(hexdec(substr($hexStr,$i,2))>=0xa1){//0xa1-0xfe
                $buffer[]=iconv("GBK",$encode,pack("H4",substr($hexStr,$i,4)));
                $i+=2;
            }else{
                $buffer[]=iconv("ISO8859-1",$encode,pack("H2",substr($hexStr,$i,2)));
            }
        }
    } elseif (($dataCoding & 0x0C) == 8) {//UCS-2BE
        for($i=0;$i<strlen($hexStr);$i+=4){
            $buffer[]=iconv("UCS-2BE",$encode,pack("H4",substr($hexStr,$i,4)));
        }
    } else {//ISO8859-1
        for($i=0;$i<strlen($hexStr);$i+=2){
            $buffer[]=iconv("ASCII",$encode,pack("H2",substr($hexStr,$i,2)));
        }
    }
    return join("",$buffer);
}


