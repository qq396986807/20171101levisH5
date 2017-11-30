<?php
header("Content-type: text/html; charset=utf-8");

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
?>