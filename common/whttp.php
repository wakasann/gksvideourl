<?php

/**
 * use Curl send Request
 * Class WHttp
 * @link  https://www.cnblogs.com/manongxiaobing/p/4698990.html CURL GET
 * @link https://www.cnblogs.com/xuzhengzong/p/7054959.html CURL GET
 * @link https://blog.csdn.net/maxsky/article/details/53296965 PHP 取302跳转后真实 URL 的两种方法
 * @link https://www.cnblogs.com/whatmiss/p/7114954.html 学习到 curl获取头部信息
 */
class WHttp
{

    public function get($url,$data = array(),$timeout = 5){
        if($timeout < 0){
            return false;
        }
        if(count($data) > 0){
            $url = $url.'?'.http_build_query($data);
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);//如果把这行注释掉的话，就会直接输出
        curl_setopt($curl, CURLOPT_TIMEOUT, (int)$timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);  // 从证书中检查SSL加密算法是否存在
        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl);

        return $result;
    }

    public function getFound($url,$data = array(),$timeout = 5){
        if($timeout < 0){
            return false;
        }
        if(count($data) > 0){
            $url = $url.'?'.http_build_query($data);
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);//如果把这行注释掉的话，就会直接输出
        curl_setopt($curl, CURLOPT_TIMEOUT, (int)$timeout);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);  // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); //302 Found
        $result = curl_exec($curl);
        //echo curl_getinfo($curl, CURLINFO_HEADER_OUT); //官方文档描述是“发送请求的字符串”，其实就是请求的header。这个就是直接查看请求header，因为上面允许查看
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl);


        return $result;
    }
}