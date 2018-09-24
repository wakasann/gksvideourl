<?php
$filePath = dirname(dirname(__FILE__));
$content = file_get_contents($filePath.'/180924182643.log');
require $filePath.'/vendor/autoload.php';
$findStr = 'window.VUE_MODEL_INIT_STATE.shortVideoComment={"work":';
$commitFindStr = '"comment"';

$findStr2 = 'id="video-box"';
$findStr3 = '账号封禁"};';

$log_file = date('ymdHis').mt_rand(1,9).'.log';
Analog::handler (Analog\Handler\File::init ($log_file));

$regex4="/<video class=\"video\".*?>.*?<\/video>/ism"; 
$regex2="/<video (.*?) src=\"(.+?)\".*?>/ism";   
if(preg_match($regex4, $content, $matches)){  
   //print_r($matches);  
   Analog::log (json_encode($matches[0]), Analog::DEBUG);
   preg_match($regex2, $matches[0], $matches2);
   Analog::log (json_encode($matches2), Analog::DEBUG);
   $mycount=count($matches2)-1;
   $imgval = $matches2[$mycount];
   echo $imgval;
}else{  
   echo '0';  
}
// $index2 = strpos($content,$findStr2);
// var_dump($index2);
// $afterContent = substr($content,$index2+strlen($findStr2));//去除掉 $findStr前面的内容
// var_dump($afterContent);
//$index3 = strpos($afterContent,$findStr3);
// var_dump($index3);
// $afterContent2 = substr($afterContent,0,$index3+strlen($findStr3)-1);
// $profileGallery = json_decode($afterContent2);
// var_dump($profileGallery->work->currentWork->playUrl);

// $log_file = date('ymdHis').'.log';
// Analog::handler (Analog\Handler\File::init ($log_file));
// Analog::log ($afterContent, Analog::DEBUG);
// Analog::log ($afterContent2, Analog::DEBUG);

exit();

$index = strpos($content,$findStr);
var_dump($index);
$afterContent = substr($content,$index+strlen($findStr));//去除掉 $findStr前面的内容
$commentIndex = strpos($afterContent,$commitFindStr);
var_dump($commentIndex);
$afterContent2 = substr($afterContent,9,$commentIndex-12);
$list = json_decode($afterContent2);
var_dump($list);

$log_file = date('ymdHis').'.log';
Analog::handler (Analog\Handler\File::init ($log_file));
//Analog::log ($afterContent, Analog::DEBUG);
Analog::log ($afterContent2, Analog::DEBUG);


