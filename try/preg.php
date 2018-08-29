<?php
$filePath = dirname(dirname(__FILE__));
$content = file_get_contents($filePath.'/180829101236.log');
require $filePath.'/vendor/autoload.php';
$findStr = 'window.VUE_MODEL_INIT_STATE.shortVideoComment={"work":';
$commitFindStr = '"comment"';

$findStr2 = 'window.VUE_MODEL_INIT_STATE[\'profileGallery\']=';
$findStr3 = '账号封禁"};';


$index2 = strpos($content,$findStr2);
var_dump($index2);
$afterContent = substr($content,$index2+strlen($findStr2));//去除掉 $findStr前面的内容
$index3 = strpos($afterContent,$findStr3);
var_dump($index3);
$afterContent2 = substr($afterContent,0,$index3+strlen($findStr3)-1);
$profileGallery = json_decode($afterContent2);
var_dump($profileGallery->work->currentWork->playUrl);

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


