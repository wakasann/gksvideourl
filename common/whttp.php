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

    //safe 模式不能curl的函数
 
    function curl_redir_exec($ch,$debug="") 
    { 
        static $curl_loops = 0; 
        static $curl_max_loops = 20; 
        try{
            if ($curl_loops++ >= $curl_max_loops) 
            { 
                $curl_loops = 0; 
                return FALSE; 
            } 
            curl_setopt($ch, CURLOPT_HEADER, true); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            $data = curl_exec($ch); 
            $debbbb = $data; 
            $tempData = explode("\n\n", $data, 2);
            if(isset($tempData[0])){
                $header = $tempData[0];
            }
            if(isset($tempData[1])){
                $data = $tempData[1];
            }
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); 

            if ($http_code == 301 || $http_code == 302) { 
                $matches = array(); 
                preg_match('/Location:(.*?)\n/', $header, $matches); 
                $url = @parse_url(trim(array_pop($matches))); 
                //print_r($url); 
                if (!$url) 
                { 
                    //couldn't process the url to redirect to 
                    $curl_loops = 0; 
                    return $data; 
                } 
                $last_url = parse_url(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL)); 
            /*    if (!$url['scheme']) 
                    $url['scheme'] = $last_url['scheme']; 
                if (!$url['host']) 
                    $url['host'] = $last_url['host']; 
                if (!$url['path']) 
                    $url['path'] = $last_url['path'];*/ 
                $new_url = $url['scheme'] . '://' . $url['host'] . $url['path'] . ($url['query']?'?'.$url['query']:''); 
                curl_setopt($ch, CURLOPT_URL, $new_url); 
            //    debug('Redirecting to', $new_url); 

                return $this->curl_redir_exec($ch); 
            } else { 
                $curl_loops=0; 
                return $debbbb; 
            } 
        }catch(\Execption $e){
            echo $e->getFile();
        }
        
    }


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
        //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); //302 Found
        $this->curl_redir_exec($curl);
        $result = curl_exec($curl);
        //echo curl_getinfo($curl, CURLINFO_HEADER_OUT); //官方文档描述是“发送请求的字符串”，其实就是请求的header。这个就是直接查看请求header，因为上面允许查看
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl);


        return $result;
    }
}