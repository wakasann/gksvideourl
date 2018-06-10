<?php
//require 'vendor/autoload.php';

//$log_file = date('ymdhis').'.log';
//Analog::handler (Analog\Handler\File::init ($log_file));


require_once 'common/tool.php';
require_once 'common/whttp.php';
$tool = new Tool();
$httpClient = new WHttp();


function debugShow($content,$title = ''){
    echo "{$title}{$content}<br/>";
}

$videoUrl = 'http://www.gifshow.com/s/okV1-SYD'; //test link
//使用 http://bitly.co/ 短地址还原得到的地址
//$videoUrl = 'https://live.kuaishou.com/u/3x2pntnj6s6y32e/3xsqpep6r8nk3gs/?fid=559580078&cc=share_copylink&groupName=E_1_180608105316137_G_4&docId=22&photoId=3xsqpep6r8nk3gs&shareId=528615268045077182&userId=3x2pntnj6s6y32e&shareType=1&et=1_i%2F1602869103662768129_h88×tamp=1528615268056';

$response = $httpClient->getFound($videoUrl);
//Analog::log ($response, Analog::WARNING);

$stringBody = (string) $response;
$playUrl = $tool->getPlayUrl($stringBody);
debugShow($playUrl);