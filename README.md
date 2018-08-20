
获取快手App中分享链接的视频地址

不熟悉正则表达式，所以目前使用字符串截取方式获取到视频地址

-----

#### 20180821

自己将代码放在自己的博客中 [解析快手链接](https://www.wakasann.xyz/kuaishouv/)

放上去之后，遇到 `Warning: curl_setopt() [function.curl-setopt]: CURLOPT_FOLLOWLOCATION cannot be activated when in safe_mode or an open_basedir is set`的警告，并进行解决

参考 [解决WordPress结构化数据插件发布文章Warning: curl_setopt() [function.curl-setopt]错误](http://www.luoxiao123.cn/7106.html),但其中的code可能会返回 offset 1 的警告

自己做了一个小小的修改


```
function curl_redir_exec($ch,$debug="") 
{ 
    static $curl_loops = 0; 
    static $curl_max_loops = 20; 
    
    if ($curl_loops++ >= $curl_max_loops) 
    { 
        $curl_loops = 0; 
        return FALSE; 
    } 
    curl_setopt($ch, CURLOPT_HEADER, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    $data = curl_exec($ch); 
    $debbbb = $data;
    // 修改了此处，explode 可能只有第1个，可能没有第2个数据
    // list($header, $data) = explode("\n\n", $data, 2);
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

        return curl_redir_exec($ch); 
    } else { 
        $curl_loops=0; 
        return $debbbb; 
    } 
    
    
}
```


#### 20180622

快手新版本中，有的视频分享时有`下载到本地`的选项，有的视频没有，故更新了第2个截取字符串规则


#### 20180611

在快手App中提交了 在 分享中添加一个 `下载本地`的按钮，因使用抖音时，是有的，当天中午 快手客服 回复我，在iphone中有下载本地的功能，而安卓中，目前只能在视频缓存文件夹(`内部存储/Android/data/com.smile.gifmaker/cache/.video_cache`)中找到需要缓存的视频文件，再保存到其它文件夹中。并已收到的建议，新版本已看到有 `下载到本地`的功能，但 发现有的短视频有这个功能，有的没有，更新的日志中也未详细说明;
